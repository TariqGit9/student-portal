<?php

namespace App\Repositories;

use App\Models\Classes;
use App\Models\ClassGrade;
use App\Models\ClassSubject;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\DB;

class ClassRepository
{
    /**
     * Get all classes for a school
     *
     * @param int $schoolId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getClassesBySchool(int $schoolId)
    {
        return Classes::with(['grade', 'subjects'])
            ->where('school_id', $schoolId)
            ->get();
    }

    /**
     * Get class with all relationships
     *
     * @param int $classId
     * @return Classes
     */
    public function getClassWithRelations(int $classId)
    {
        return Classes::with([
            'grade',
            'subjects',
            'students',
            'students.student_details',
            'attendance'
        ])->findOrFail($classId);
    }

    /**
     * Create a new class
     *
     * @param array $data
     * @return Classes
     */
    public function createClass(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create class
            $class = Classes::create([
                'name' => $data['name'],
                'class_grade_id' => $data['class_grade_id'],
                'school_id' => $data['school_id'],
                'capacity' => $data['capacity'] ?? null,
                'room_number' => $data['room_number'] ?? null,
                'status' => $data['status'] ?? 1
            ]);

            // Assign subjects if provided
            if (isset($data['subject_ids']) && is_array($data['subject_ids'])) {
                foreach ($data['subject_ids'] as $subjectId) {
                    ClassSubject::create([
                        'class_id' => $class->id,
                        'subject_id' => $subjectId
                    ]);
                }
            }

            return $class;
        });
    }

    /**
     * Update a class
     *
     * @param int $classId
     * @param array $data
     * @return Classes
     */
    public function updateClass(int $classId, array $data)
    {
        return DB::transaction(function () use ($classId, $data) {
            $class = Classes::findOrFail($classId);
            
            // Update class details
            $class->update([
                'name' => $data['name'] ?? $class->name,
                'class_grade_id' => $data['class_grade_id'] ?? $class->class_grade_id,
                'capacity' => $data['capacity'] ?? $class->capacity,
                'room_number' => $data['room_number'] ?? $class->room_number,
                'status' => $data['status'] ?? $class->status
            ]);

            // Update subjects if provided
            if (isset($data['subject_ids']) && is_array($data['subject_ids'])) {
                // Remove existing subjects
                ClassSubject::where('class_id', $classId)->delete();
                
                // Add new subjects
                foreach ($data['subject_ids'] as $subjectId) {
                    ClassSubject::create([
                        'class_id' => $class->id,
                        'subject_id' => $subjectId
                    ]);
                }
            }

            return $class;
        });
    }

    /**
     * Assign teacher to class subjects
     *
     * @param int $teacherId
     * @param int $classId
     * @param array $subjectIds
     * @return void
     */
    public function assignTeacherToClass(int $teacherId, int $classId, array $subjectIds)
    {
        DB::transaction(function () use ($teacherId, $classId, $subjectIds) {
            // Remove existing assignments for this teacher and class
            TeacherSubject::where('teacher_id', $teacherId)
                ->where('class_id', $classId)
                ->delete();
            
            // Create new assignments
            foreach ($subjectIds as $subjectId) {
                TeacherSubject::create([
                    'teacher_id' => $teacherId,
                    'subject_id' => $subjectId,
                    'class_id' => $classId
                ]);
            }
        });
    }

    /**
     * Get class grades
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getClassGrades()
    {
        return ClassGrade::with('subjects')->get();
    }

    /**
     * Get students count by class
     *
     * @param int $classId
     * @return int
     */
    public function getStudentCount(int $classId)
    {
        $class = Classes::findOrFail($classId);
        return $class->students()->count();
    }

    /**
     * Check if class is full
     *
     * @param int $classId
     * @return bool
     */
    public function isClassFull(int $classId)
    {
        $class = Classes::findOrFail($classId);
        
        if (!$class->capacity) {
            return false; // No capacity limit
        }
        
        $currentCount = $this->getStudentCount($classId);
        return $currentCount >= $class->capacity;
    }

    /**
     * Delete a class
     *
     * @param int $classId
     * @return bool
     */
    public function deleteClass(int $classId)
    {
        return DB::transaction(function () use ($classId) {
            $class = Classes::findOrFail($classId);
            
            // Check if class has students
            if ($class->students()->exists()) {
                throw new \Exception('Cannot delete class with enrolled students');
            }
            
            // Delete class subjects
            ClassSubject::where('class_id', $classId)->delete();
            
            // Delete teacher assignments
            TeacherSubject::where('class_id', $classId)->delete();
            
            // Delete class
            return $class->delete();
        });
    }
}