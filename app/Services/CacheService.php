<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheService
{
    /**
     * Cache TTL constants (in minutes)
     */
    const TTL_SHORT = 5;        // 5 minutes
    const TTL_MEDIUM = 30;      // 30 minutes
    const TTL_LONG = 60;        // 1 hour
    const TTL_DAY = 1440;       // 24 hours
    const TTL_WEEK = 10080;     // 7 days

    /**
     * Cache key prefixes
     */
    const PREFIX_USER = 'user:';
    const PREFIX_SCHOOL = 'school:';
    const PREFIX_CLASS = 'class:';
    const PREFIX_STUDENT = 'student:';
    const PREFIX_TEACHER = 'teacher:';
    const PREFIX_SESSION = 'session:';
    const PREFIX_RESULTS = 'results:';
    const PREFIX_ATTENDANCE = 'attendance:';

    /**
     * Get or set cached data
     *
     * @param string $key
     * @param callable $callback
     * @param int $ttl
     * @return mixed
     */
    public function remember(string $key, callable $callback, int $ttl = self::TTL_MEDIUM)
    {
        try {
            return Cache::remember($key, $ttl * 60, $callback);
        } catch (\Exception $e) {
            Log::error('Cache error: ' . $e->getMessage());
            return $callback();
        }
    }

    /**
     * Get cached data
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        try {
            return Cache::get($key, $default);
        } catch (\Exception $e) {
            Log::error('Cache get error: ' . $e->getMessage());
            return $default;
        }
    }

    /**
     * Set cached data
     *
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set(string $key, $value, int $ttl = self::TTL_MEDIUM)
    {
        try {
            return Cache::put($key, $value, $ttl * 60);
        } catch (\Exception $e) {
            Log::error('Cache set error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete cached data
     *
     * @param string $key
     * @return bool
     */
    public function forget(string $key)
    {
        try {
            return Cache::forget($key);
        } catch (\Exception $e) {
            Log::error('Cache forget error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete multiple cache keys by pattern
     *
     * @param string $pattern
     * @return void
     */
    public function forgetByPattern(string $pattern)
    {
        try {
            $keys = Cache::getRedis()->keys($pattern);
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        } catch (\Exception $e) {
            Log::error('Cache pattern forget error: ' . $e->getMessage());
        }
    }

    /**
     * Cache user data
     *
     * @param int $userId
     * @param mixed $userData
     * @return bool
     */
    public function cacheUser(int $userId, $userData)
    {
        $key = self::PREFIX_USER . $userId;
        return $this->set($key, $userData, self::TTL_LONG);
    }

    /**
     * Get cached user data
     *
     * @param int $userId
     * @return mixed
     */
    public function getUser(int $userId)
    {
        $key = self::PREFIX_USER . $userId;
        return $this->get($key);
    }

    /**
     * Clear user cache
     *
     * @param int $userId
     * @return bool
     */
    public function clearUserCache(int $userId)
    {
        $key = self::PREFIX_USER . $userId;
        return $this->forget($key);
    }

    /**
     * Cache school data
     *
     * @param int $schoolId
     * @param mixed $schoolData
     * @return bool
     */
    public function cacheSchool(int $schoolId, $schoolData)
    {
        $key = self::PREFIX_SCHOOL . $schoolId;
        return $this->set($key, $schoolData, self::TTL_DAY);
    }

    /**
     * Get cached school data
     *
     * @param int $schoolId
     * @return mixed
     */
    public function getSchool(int $schoolId)
    {
        $key = self::PREFIX_SCHOOL . $schoolId;
        return $this->get($key);
    }

    /**
     * Cache class students list
     *
     * @param int $classId
     * @param mixed $students
     * @return bool
     */
    public function cacheClassStudents(int $classId, $students)
    {
        $key = self::PREFIX_CLASS . $classId . ':students';
        return $this->set($key, $students, self::TTL_MEDIUM);
    }

    /**
     * Get cached class students
     *
     * @param int $classId
     * @return mixed
     */
    public function getClassStudents(int $classId)
    {
        $key = self::PREFIX_CLASS . $classId . ':students';
        return $this->get($key);
    }

    /**
     * Cache student results
     *
     * @param int $studentId
     * @param int $sessionId
     * @param mixed $results
     * @return bool
     */
    public function cacheStudentResults(int $studentId, int $sessionId, $results)
    {
        $key = self::PREFIX_RESULTS . $studentId . ':' . $sessionId;
        return $this->set($key, $results, self::TTL_LONG);
    }

    /**
     * Get cached student results
     *
     * @param int $studentId
     * @param int $sessionId
     * @return mixed
     */
    public function getStudentResults(int $studentId, int $sessionId)
    {
        $key = self::PREFIX_RESULTS . $studentId . ':' . $sessionId;
        return $this->get($key);
    }

    /**
     * Clear student results cache
     *
     * @param int $studentId
     * @return void
     */
    public function clearStudentResultsCache(int $studentId)
    {
        $pattern = self::PREFIX_RESULTS . $studentId . ':*';
        $this->forgetByPattern($pattern);
    }

    /**
     * Cache attendance data
     *
     * @param int $classId
     * @param string $date
     * @param mixed $attendance
     * @return bool
     */
    public function cacheAttendance(int $classId, string $date, $attendance)
    {
        $key = self::PREFIX_ATTENDANCE . $classId . ':' . $date;
        return $this->set($key, $attendance, self::TTL_DAY);
    }

    /**
     * Get cached attendance
     *
     * @param int $classId
     * @param string $date
     * @return mixed
     */
    public function getAttendance(int $classId, string $date)
    {
        $key = self::PREFIX_ATTENDANCE . $classId . ':' . $date;
        return $this->get($key);
    }

    /**
     * Clear all cache for a school
     *
     * @param int $schoolId
     * @return void
     */
    public function clearSchoolCache(int $schoolId)
    {
        // Clear school data
        $this->forget(self::PREFIX_SCHOOL . $schoolId);
        
        // Clear related caches
        $this->forgetByPattern(self::PREFIX_CLASS . '*');
        $this->forgetByPattern(self::PREFIX_STUDENT . '*');
        $this->forgetByPattern(self::PREFIX_TEACHER . '*');
        
        Log::info('Cleared all cache for school: ' . $schoolId);
    }

    /**
     * Flush all cache
     *
     * @return bool
     */
    public function flushAll()
    {
        try {
            return Cache::flush();
        } catch (\Exception $e) {
            Log::error('Cache flush error: ' . $e->getMessage());
            return false;
        }
    }
}