<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Student Portal Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all configuration options for the student portal
    | application including upload settings, cache configuration, and
    | business logic settings.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    */
    'uploads' => [
        'avatars' => [
            'max_size' => 2048, // KB
            'allowed_types' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
            'storage_disk' => 'public',
            'path' => 'uploads/avatars',
        ],
        'documents' => [
            'max_size' => 10240, // KB
            'allowed_types' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
            'storage_disk' => 'public',
            'path' => 'uploads/documents',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'default_ttl' => 30, // minutes
        'dashboard_ttl' => 5, // minutes
        'user_data_ttl' => 60, // minutes
        'static_data_ttl' => 1440, // minutes (24 hours)
        'reports_ttl' => 15, // minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    */
    'pagination' => [
        'per_page' => 25,
        'datatables_length' => 10,
        'max_per_page' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    */
    'security' => [
        'password_min_length' => 8,
        'session_timeout' => 120, // minutes
        'max_login_attempts' => 5,
        'lockout_duration' => 15, // minutes
        'password_reset_timeout' => 60, // minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Academic Settings
    |--------------------------------------------------------------------------
    */
    'academic' => [
        'default_session_duration' => 12, // months
        'passing_marks_percentage' => 40,
        'max_class_capacity' => 50,
        'default_class_capacity' => 30,
        'attendance_grace_period' => 10, // minutes
        'marks_range' => [
            'min' => 0,
            'max' => 100,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Grade Boundaries
    |--------------------------------------------------------------------------
    */
    'grades' => [
        'A+' => ['min' => 90, 'max' => 100],
        'A'  => ['min' => 80, 'max' => 89],
        'B+' => ['min' => 70, 'max' => 79],
        'B'  => ['min' => 60, 'max' => 69],
        'C+' => ['min' => 50, 'max' => 59],
        'C'  => ['min' => 40, 'max' => 49],
        'D'  => ['min' => 33, 'max' => 39],
        'F'  => ['min' => 0,  'max' => 32],
    ],

    /*
    |--------------------------------------------------------------------------
    | Fee Management
    |--------------------------------------------------------------------------
    */
    'fees' => [
        'currency' => 'PKR',
        'currency_symbol' => 'Rs.',
        'late_fee_percentage' => 10,
        'late_fee_grace_days' => 7,
        'discount_types' => [
            'percentage' => 'Percentage',
            'fixed' => 'Fixed Amount',
        ],
        'payment_methods' => [
            'cash' => 'Cash',
            'bank_transfer' => 'Bank Transfer',
            'online' => 'Online Payment',
            'cheque' => 'Cheque',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Communication Settings
    |--------------------------------------------------------------------------
    */
    'communication' => [
        'email_notifications' => true,
        'sms_notifications' => false,
        'notification_types' => [
            'attendance' => 'Attendance Updates',
            'marks' => 'Marks Updates',
            'fees' => 'Fee Reminders',
            'announcements' => 'School Announcements',
            'disciplinary' => 'Disciplinary Actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Settings
    |--------------------------------------------------------------------------
    */
    'reports' => [
        'formats' => ['pdf', 'excel', 'csv'],
        'default_format' => 'pdf',
        'batch_size' => 1000, // for large reports
        'cache_reports' => true,
        'report_cache_ttl' => 60, // minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Settings
    |--------------------------------------------------------------------------
    */
    'backup' => [
        'automatic_backup' => true,
        'backup_frequency' => 'daily', // daily, weekly, monthly
        'backup_retention_days' => 30,
        'backup_storage_disk' => 'local',
        'backup_path' => 'backups',
    ],

    /*
    |--------------------------------------------------------------------------
    | System Limits
    |--------------------------------------------------------------------------
    */
    'limits' => [
        'max_schools_per_branch' => 10,
        'max_classes_per_school' => 50,
        'max_subjects_per_class' => 15,
        'max_students_per_class' => 50,
        'max_teachers_per_school' => 100,
        'max_assessment_types' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Values
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'user_status' => 1, // active
        'school_status' => 1, // active
        'class_status' => 1, // active
        'session_status' => 1, // active
        'avatar' => [
            'student' => 'uploads/student_avatars/default.webp',
            'teacher' => 'uploads/teacher_avatars/default.webp',
            'school' => 'uploads/school_avatars/default.webp',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Blood Groups
    |--------------------------------------------------------------------------
    */
    'blood_groups' => [
        'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
    ],

    /*
    |--------------------------------------------------------------------------
    | Gender Options
    |--------------------------------------------------------------------------
    */
    'genders' => [
        'male' => 'Male',
        'female' => 'Female',
        'other' => 'Other',
    ],

    /*
    |--------------------------------------------------------------------------
    | Time Zones
    |--------------------------------------------------------------------------
    */
    'timezone' => env('APP_TIMEZONE', 'Asia/Karachi'),

    /*
    |--------------------------------------------------------------------------
    | Date Formats
    |--------------------------------------------------------------------------
    */
    'date_formats' => [
        'display' => 'd-m-Y',
        'input' => 'Y-m-d',
        'datetime' => 'd-m-Y H:i:s',
        'time' => 'H:i',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Settings
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'log_user_activities' => true,
        'log_api_requests' => true,
        'log_database_queries' => false, // Enable only for debugging
        'retention_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Settings
    |--------------------------------------------------------------------------
    */
    'api' => [
        'rate_limit' => 60, // requests per minute
        'version' => 'v1',
        'pagination_limit' => 50,
        'default_per_page' => 15,
    ],
];