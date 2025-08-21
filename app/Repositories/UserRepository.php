<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserDetails\StudentDetails;
use App\Models\UserDetails\TeacherDetails;
use App\Models\UserDetails\AdminDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Create a new teacher
     *
     * @param array $userData
     * @param array $teacherData
     * @return User
     */
    public function createTeacher(array $userData, array $teacherData)
    {
        return DB::transaction(function () use ($userData, $teacherData) {
            // Hash password if provided
            if (isset($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            }
            
            // Set role for teacher
            $userData['role_id'] = 2;
            
            // Create user
            $user = User::create($userData);
            
            // Create teacher details
            $teacherData['user_id'] = $user->id;
            TeacherDetails::create($teacherData);
            
            return $user;
        });
    }

    /**
     * Create a new student
     *
     * @param array $userData
     * @param array $studentData
     * @return User
     */
    public function createStudent(array $userData, array $studentData)
    {
        return DB::transaction(function () use ($userData, $studentData) {
            // Hash password if provided
            if (isset($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            }
            
            // Set role for student
            $userData['role_id'] = 3;
            
            // Create user
            $user = User::create($userData);
            
            // Create student details
            $studentData['user_id'] = $user->id;
            StudentDetails::create($studentData);
            
            return $user;
        });
    }

    /**
     * Update teacher
     *
     * @param int $userId
     * @param array $userData
     * @param array $teacherData
     * @return User
     */
    public function updateTeacher(int $userId, array $userData, array $teacherData)
    {
        return DB::transaction(function () use ($userId, $userData, $teacherData) {
            // Find user
            $user = User::findOrFail($userId);
            
            // Hash password if provided
            if (isset($userData['password']) && !empty($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            } else {
                unset($userData['password']);
            }
            
            // Update user
            $user->update($userData);
            
            // Update teacher details
            $user->teacher_details()->update($teacherData);
            
            return $user;
        });
    }

    /**
     * Update student
     *
     * @param int $userId
     * @param array $userData
     * @param array $studentData
     * @return User
     */
    public function updateStudent(int $userId, array $userData, array $studentData)
    {
        return DB::transaction(function () use ($userId, $userData, $studentData) {
            // Find user
            $user = User::findOrFail($userId);
            
            // Hash password if provided
            if (isset($userData['password']) && !empty($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            } else {
                unset($userData['password']);
            }
            
            // Update user
            $user->update($userData);
            
            // Update student details
            $user->student_details()->update($studentData);
            
            return $user;
        });
    }

    /**
     * Get teachers with eager loading
     *
     * @param int $schoolId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTeachers(int $schoolId)
    {
        return User::with(['teacher_details', 'school'])
            ->where('role_id', 2)
            ->where('school_information_id', $schoolId)
            ->get();
    }

    /**
     * Get students with eager loading
     *
     * @param int $schoolId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudents(int $schoolId)
    {
        return User::with(['student_details', 'student_details.class', 'school'])
            ->where('role_id', 3)
            ->where('school_information_id', $schoolId)
            ->get();
    }

    /**
     * Get students by class
     *
     * @param int $classId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudentsByClass(int $classId)
    {
        return User::with(['student_details', 'student_details.class'])
            ->where('role_id', 3)
            ->whereHas('student_details', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->get();
    }

    /**
     * Delete a user (soft delete)
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId)
    {
        $user = User::findOrFail($userId);
        
        return DB::transaction(function () use ($user) {
            // Soft delete related details based on role
            if ($user->role_id == 2 && $user->teacher_details) {
                $user->teacher_details->delete();
            } elseif ($user->role_id == 3 && $user->student_details) {
                $user->student_details->delete();
            }
            
            // Soft delete user
            return $user->delete();
        });
    }

    /**
     * Toggle user status
     *
     * @param int $userId
     * @return User
     */
    public function toggleUserStatus(int $userId)
    {
        $user = User::findOrFail($userId);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();
        
        return $user;
    }

    /**
     * Get user by email or username
     *
     * @param string $login
     * @return User|null
     */
    public function getUserByLogin(string $login)
    {
        return User::where('email', $login)
            ->orWhere('user_name', $login)
            ->first();
    }
}