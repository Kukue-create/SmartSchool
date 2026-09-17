<?php

return [
    'name' => 'Seke 1 High School',

    'email_domains' => [
        'student' => env('SCHOOL_STUDENT_EMAIL_DOMAIN', 'students.seke1.ac.zw'),
        'teacher' => env('SCHOOL_TEACHER_EMAIL_DOMAIN', 'staff.seke1.ac.zw'),
        'school_admin' => env('SCHOOL_ADMIN_EMAIL_DOMAIN', 'admin.ac.zw'),
    ],

    'system_admin_password' => env('SYSTEM_ADMIN_PASSWORD'),

    'levels' => [
        'Form 1', 'Form 2', 'Form 3', 'Form 4',
        'Lower 6', 'Upper 6',
    ],

    // Full list of selectable classes, grouped by level, matching the brief exactly.
    'classes_by_level' => [
        'Form 1' => ['1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '1.10', '1.11', '1.12'],
        'Form 2' => ['2.1', '2.2', '2.3', '2.4', '2.5', '2.6', '2.7', '2.8', '2.9', '2.10', '2.11', '2.12'],
        'Form 3' => ['3.1', '3.2', '3.3', '3.4', '3.5', '3.6', '3.7', '3.8', '3.9', '3.10', '3.11', '3.12'],
        'Form 4' => ['4.1', '4.2', '4.3', '4.4', '4.5', '4.6', '4.7', '4.8', '4.9', '4.10', '4.11', '4.12'],
        'Lower 6' => ['Lower 6 Sciences', 'Lower 6 Commercials', 'Lower 6 Arts'],
        'Upper 6' => ['Upper 6 Sciences', 'Upper 6 Commercials', 'Upper 6 Arts'],
    ],

    'subjects' => [
        'Maths', 'English', 'Combined Science', 'Shona', 'History', 'Heritage',
        'Commerce', 'Accounts', 'BS', 'Economics', 'Biology',
        'Physics', 'Chemistry', 'Computers', 'Fashion and Fabrics',
        'Food and Technology', 'WoodWork', 'Metal Work', 'Building', 'Agriculture',
    ],

    'max_classes_per_teacher' => 10,

    // A class teacher (homeroom teacher) may be the class teacher of at most
    // this many classes, and marks attendance only for those classes.
    'max_class_teacher_classes' => 2,

    'genders' => ['Male', 'Female'],
];
