<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\ClassRepository;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentManagementService
{
    protected $userRepository;
    protected $classRepository;
    protected $fileUploadService;

    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository,
        FileUploadService $fileUploadService
    ) {
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Register a new student
     *
     * @param array $data
     * @return array
     */
    public function registerStudent(array $data)
    {
        try {
            // Check if class is full
            if ($this->classRepository->isClassFull($data['class_id'])) {
                return [
                    'success' => false,
                    'message' => 'The selected class is full'
                ];
            }

            DB::beginTransaction();

            // Prepare user data
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'user_name' => $data['user_name'],
                'password' => $data['password'],
                'school_information_id' => $data['school_id'],
                'status' => 1
            ];

            // Handle avatar upload
            if (isset($data['avatar']) && $data['avatar']) {
                $uploadResult = $this->fileUploadService->uploadAvatar($data['avatar'], 'student');
                if ($uploadResult['success']) {
                    $userData['avatar'] = $uploadResult['path'];
                } else {
                    throw new \Exception($uploadResult['error']);
                }
            }

            // Prepare student details data
            $studentData = [
                'registration_id' => $data['registration_id'],
                'roll_no' => $data['roll_no'],
                'father_name' => $data['father_name'],
                'father_cnic' => $data['father_cnic'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'phone' => $data['phone'],
                'father_phone' => $data['father_phone'] ?? null,
                'address' => $data['address'],
                'class_id' => $data['class_id'],
                'admission_date' => $data['admission_date'],
                'monthly_fee' => $data['monthly_fee'],
                'emergency_contact' => $data['emergency_contact'] ?? null,
                'blood_group' => $data['blood_group'] ?? null,
                'medical_conditions' => $data['medical_conditions'] ?? null
            ];

            // Create student
            $student = $this->userRepository->createStudent($userData, $studentData);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Student registered successfully',
                'student' => $student
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student registration failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to register student: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update student information
     *
     * @param int $studentId
     * @param array $data
     * @return array
     */
    public function updateStudent(int $studentId, array $data)
    {
        try {
            DB::beginTransaction();

            // Prepare user data
            $userData = [];
            if (isset($data['name'])) $userData['name'] = $data['name'];
            if (isset($data['email'])) $userData['email'] = $data['email'];
            if (isset($data['user_name'])) $userData['user_name'] = $data['user_name'];
            if (isset($data['password']) && !empty($data['password'])) {
                $userData['password'] = $data['password'];
            }
            if (isset($data['status'])) $userData['status'] = $data['status'];

            // Handle avatar upload
            if (isset($data['avatar']) && $data['avatar']) {
                $uploadResult = $this->fileUploadService->uploadAvatar($data['avatar'], 'student');
                if ($uploadResult['success']) {
                    $userData['avatar'] = $uploadResult['path'];
                } else {
                    throw new \Exception($uploadResult['error']);
                }
            }

            // Prepare student details data
            $studentData = [];
            $fieldsToUpdate = [
                'registration_id', 'roll_no', 'father_name', 'father_cnic',
                'date_of_birth', 'gender', 'phone', 'father_phone', 'address',
                'class_id', 'monthly_fee', 'emergency_contact', 'blood_group',
                'medical_conditions'
            ];

            foreach ($fieldsToUpdate as $field) {
                if (isset($data[$field])) {
                    $studentData[$field] = $data[$field];
                }
            }

            // Update student
            $student = $this->userRepository->updateStudent($studentId, $userData, $studentData);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Student updated successfully',
                'student' => $student
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student update failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to update student: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get students by class
     *
     * @param int $classId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudentsByClass(int $classId)
    {
        return $this->userRepository->getStudentsByClass($classId);
    }

    /**
     * Get all students for a school
     *
     * @param int $schoolId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudentsBySchool(int $schoolId)
    {
        return $this->userRepository->getStudents($schoolId);
    }

    /**
     * Promote students to next class
     *
     * @param array $studentIds
     * @param int $newClassId
     * @return array
     */
    public function promoteStudents(array $studentIds, int $newClassId)
    {
        try {
            // Check if new class is full
            $currentCount = $this->classRepository->getStudentCount($newClassId);
            $class = $this->classRepository->getClassWithRelations($newClassId);
            
            if ($class->capacity && ($currentCount + count($studentIds)) > $class->capacity) {
                return [
                    'success' => false,
                    'message' => 'The new class does not have enough capacity for all students'
                ];
            }

            DB::beginTransaction();

            $promoted = 0;
            foreach ($studentIds as $studentId) {
                $student = $this->userRepository->updateStudent($studentId, [], ['class_id' => $newClassId]);
                if ($student) {
                    $promoted++;
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => "{$promoted} students promoted successfully"
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student promotion failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to promote students: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete a student
     *
     * @param int $studentId
     * @return array
     */
    public function deleteStudent(int $studentId)
    {
        try {
            $result = $this->userRepository->deleteUser($studentId);
            
            return [
                'success' => $result,
                'message' => $result ? 'Student deleted successfully' : 'Failed to delete student'
            ];
        } catch (\Exception $e) {
            Log::error('Student deletion failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to delete student: ' . $e->getMessage()
            ];
        }
    }
}