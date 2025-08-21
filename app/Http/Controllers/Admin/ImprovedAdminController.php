<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherRequest;
use App\Http\Requests\Admin\StoreStudentRequest;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Services\StudentManagementService;
use App\Services\CacheService;
use App\Repositories\UserRepository;
use App\Repositories\ClassRepository;
use App\Exceptions\CustomExceptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ImprovedAdminController extends Controller
{
    protected $studentService;
    protected $cacheService;
    protected $userRepository;
    protected $classRepository;

    public function __construct(
        StudentManagementService $studentService,
        CacheService $cacheService,
        UserRepository $userRepository,
        ClassRepository $classRepository
    ) {
        $this->studentService = $studentService;
        $this->cacheService = $cacheService;
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
    }

    /**
     * Display admin dashboard
     */
    public function index()
    {
        try {
            $schoolId = Auth::user()->school_information_id;
            
            // Cache dashboard data
            $dashboardData = $this->cacheService->remember(
                "dashboard:admin:{$schoolId}",
                function () use ($schoolId) {
                    return [
                        'total_students' => $this->userRepository->getStudents($schoolId)->count(),
                        'total_teachers' => $this->userRepository->getTeachers($schoolId)->count(),
                        'total_classes' => $this->classRepository->getClassesBySchool($schoolId)->count(),
                        'recent_activities' => [] // Add your recent activities logic here
                    ];
                },
                CacheService::TTL_SHORT
            );

            return view('admin.dashboard', compact('dashboardData'));
        } catch (\Exception $e) {
            Log::error('Admin dashboard error: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to load dashboard data');
        }
    }

    /**
     * Store a new teacher
     */
    public function storeTeacher(StoreTeacherRequest $request)
    {
        try {
            $data = $request->validated();
            $data['school_id'] = Auth::user()->school_information_id;

            $result = $this->userRepository->createTeacher(
                $data,
                array_diff_key($data, array_flip(['name', 'email', 'user_name', 'password', 'avatar']))
            );

            // Clear relevant caches
            $this->cacheService->clearSchoolCache($data['school_id']);

            return response()->json([
                'success' => true,
                'message' => 'Teacher created successfully',
                'teacher' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Teacher creation failed: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to create teacher');
        }
    }

    /**
     * Store a new student
     */
    public function storeStudent(StoreStudentRequest $request)
    {
        try {
            $data = $request->validated();
            $data['school_id'] = Auth::user()->school_information_id;

            $result = $this->studentService->registerStudent($data);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'student' => $result['student']
            ]);

        } catch (\Exception $e) {
            Log::error('Student creation failed: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to create student');
        }
    }

    /**
     * Update teacher
     */
    public function updateTeacher(UpdateTeacherRequest $request, $teacherId)
    {
        try {
            $data = $request->validated();
            
            $result = $this->userRepository->updateTeacher(
                $teacherId,
                $data,
                array_diff_key($data, array_flip(['name', 'email', 'user_name', 'password', 'avatar', 'status']))
            );

            // Clear caches
            $this->cacheService->clearUserCache($teacherId);
            $this->cacheService->clearSchoolCache(Auth::user()->school_information_id);

            return response()->json([
                'success' => true,
                'message' => 'Teacher updated successfully',
                'teacher' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Teacher update failed: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to update teacher');
        }
    }

    /**
     * Update student
     */
    public function updateStudent(UpdateStudentRequest $request, $studentId)
    {
        try {
            $data = $request->validated();
            
            $result = $this->studentService->updateStudent($studentId, $data);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'student' => $result['student']
            ]);

        } catch (\Exception $e) {
            Log::error('Student update failed: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to update student');
        }
    }

    /**
     * Get teachers DataTable
     */
    public function getTeachersDataTable()
    {
        try {
            $schoolId = Auth::user()->school_information_id;
            
            $teachers = $this->cacheService->remember(
                "teachers:datatable:{$schoolId}",
                function () use ($schoolId) {
                    return $this->userRepository->getTeachers($schoolId);
                },
                CacheService::TTL_SHORT
            );

            return DataTables::of($teachers)
                ->addColumn('action', function ($teacher) {
                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= '<button class="btn btn-sm btn-primary edit-teacher" data-id="' . $teacher->id . '">Edit</button>';
                    $buttons .= '<button class="btn btn-sm btn-danger delete-teacher" data-id="' . $teacher->id . '">Delete</button>';
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->addColumn('status', function ($teacher) {
                    $status = $teacher->status ? 'Active' : 'Inactive';
                    $class = $teacher->status ? 'success' : 'danger';
                    return '<span class="badge badge-' . $class . '">' . $status . '</span>';
                })
                ->addColumn('subjects', function ($teacher) {
                    if ($teacher->teacher_details && $teacher->teacher_details->subjects) {
                        return $teacher->teacher_details->subjects->pluck('name')->implode(', ');
                    }
                    return 'No subjects assigned';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);

        } catch (\Exception $e) {
            Log::error('Teachers DataTable error: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to load teachers data');
        }
    }

    /**
     * Get students DataTable
     */
    public function getStudentsDataTable()
    {
        try {
            $schoolId = Auth::user()->school_information_id;
            
            $students = $this->cacheService->remember(
                "students:datatable:{$schoolId}",
                function () use ($schoolId) {
                    return $this->userRepository->getStudents($schoolId);
                },
                CacheService::TTL_SHORT
            );

            return DataTables::of($students)
                ->addColumn('action', function ($student) {
                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= '<button class="btn btn-sm btn-primary edit-student" data-id="' . $student->id . '">Edit</button>';
                    $buttons .= '<button class="btn btn-sm btn-info view-student" data-id="' . $student->id . '">View</button>';
                    $buttons .= '<button class="btn btn-sm btn-danger delete-student" data-id="' . $student->id . '">Delete</button>';
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->addColumn('status', function ($student) {
                    $status = $student->status ? 'Active' : 'Inactive';
                    $class = $student->status ? 'success' : 'danger';
                    return '<span class="badge badge-' . $class . '">' . $status . '</span>';
                })
                ->addColumn('class', function ($student) {
                    if ($student->student_details && $student->student_details->class) {
                        return $student->student_details->class->name;
                    }
                    return 'No class assigned';
                })
                ->addColumn('registration_id', function ($student) {
                    return $student->student_details ? $student->student_details->registration_id : '';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);

        } catch (\Exception $e) {
            Log::error('Students DataTable error: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to load students data');
        }
    }

    /**
     * Delete teacher
     */
    public function deleteTeacher($teacherId)
    {
        try {
            $result = $this->userRepository->deleteUser($teacherId);
            
            if ($result) {
                // Clear caches
                $this->cacheService->clearUserCache($teacherId);
                $this->cacheService->clearSchoolCache(Auth::user()->school_information_id);
            }

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Teacher deleted successfully' : 'Failed to delete teacher'
            ]);

        } catch (\Exception $e) {
            Log::error('Teacher deletion failed: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to delete teacher');
        }
    }

    /**
     * Delete student
     */
    public function deleteStudent($studentId)
    {
        try {
            $result = $this->studentService->deleteStudent($studentId);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message']
            ]);

        } catch (\Exception $e) {
            Log::error('Student deletion failed: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to delete student');
        }
    }

    /**
     * Toggle user status
     */
    public function toggleUserStatus($userId)
    {
        try {
            $user = $this->userRepository->toggleUserStatus($userId);
            
            // Clear user cache
            $this->cacheService->clearUserCache($userId);

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'status' => $user->status
            ]);

        } catch (\Exception $e) {
            Log::error('User status toggle failed: ' . $e->getMessage());
            throw new CustomExceptions\DatabaseException('Failed to update user status');
        }
    }
}