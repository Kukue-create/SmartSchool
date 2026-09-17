<?php

use App\Http\Controllers\Admin\SystemAdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\SchoolAdminRegistrationController;
use App\Http\Controllers\Auth\StudentRegistrationController;
use App\Http\Controllers\Auth\SystemAdminAuthController;
use App\Http\Controllers\Auth\TeacherRegistrationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');

Route::get('/enroll', [EnrollmentController::class, 'create'])->name('enrollment.create');
Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');

/*
|--------------------------------------------------------------------------
| Registration (guest only) - step 1 shared, step 2 per role
|--------------------------------------------------------------------------
| The public entry point is student-only: /students. There is no visible
| role picker. Staff reach their own registration step by appending a
| word to that same URL, and the system administrator portal is reached
| the same way:
|
|   /students                 -> student registration (step 1)
|   /students/details         -> student registration (step 2)
|   /students/teachers        -> teacher registration (step 1)
|   /students/teachers/details -> teacher registration (step 2)
|   /students/admin           -> school admin registration (step 1)
|   /students/admin/details   -> school admin registration (step 2)
|   /students/online          -> system administrator portal login
*/
Route::middleware('guest')->group(function () {
    Route::get('/students', [RegistrationController::class, 'create'])->defaults('role', 'student')->name('register');
    Route::post('/students', [RegistrationController::class, 'store'])->defaults('role', 'student')->name('register.store');

    Route::get('/students/details', [StudentRegistrationController::class, 'create'])->name('register.student');
    Route::post('/students/details', [StudentRegistrationController::class, 'store'])->name('register.student.store');

    Route::get('/students/teachers', [RegistrationController::class, 'create'])->defaults('role', 'teacher')->name('register.teacher.entry');
    Route::post('/students/teachers', [RegistrationController::class, 'store'])->defaults('role', 'teacher')->name('register.teacher.entry.store');

    Route::get('/students/teachers/details', [TeacherRegistrationController::class, 'create'])->name('register.teacher');
    Route::post('/students/teachers/details', [TeacherRegistrationController::class, 'store'])->name('register.teacher.store');

    Route::get('/students/admin', [RegistrationController::class, 'create'])->defaults('role', 'school_admin')->name('register.school-admin.entry');
    Route::post('/students/admin', [RegistrationController::class, 'store'])->defaults('role', 'school_admin')->name('register.school-admin.entry.store');

    Route::get('/students/admin/details', [SchoolAdminRegistrationController::class, 'create'])->name('register.school-admin');
    Route::post('/students/admin/details', [SchoolAdminRegistrationController::class, 'store'])->name('register.school-admin.store');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/students/online', [SystemAdminAuthController::class, 'create'])->name('system-admin.login');
    Route::post('/students/online', [SystemAdminAuthController::class, 'store'])->name('system-admin.login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated (student / teacher / school_admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notices - public to every registered/logged-in user.
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');

    // Timetables - viewable by everyone logged in.
    Route::get('/timetables', [TimetableController::class, 'index'])->name('timetables.index');

    // Library - browsing viewable by everyone logged in.
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');

    /*
    |--------------------------------------------------------------------
    | Student-only
    |--------------------------------------------------------------------
    */
    Route::middleware('role:student')->group(function () {
        Route::get('/my-results', [ResultController::class, 'mine'])->name('results.mine');
        Route::get('/my-fees', [FeeController::class, 'mine'])->name('fees.mine');
        Route::post('/my-fees/pay', [FeeController::class, 'pay'])->name('fees.pay');
        Route::get('/my-attendance', [AttendanceController::class, 'mine'])->name('attendance.mine');
        Route::post('/library/{book}/borrow', [LibraryController::class, 'borrow'])->name('library.borrow');
    });

    /*
    |--------------------------------------------------------------------
    | Teacher-only
    |--------------------------------------------------------------------
    */
    Route::middleware('role:teacher')->group(function () {
        Route::get('/results/manage', [ResultController::class, 'manage'])->name('results.manage');
        Route::post('/results', [ResultController::class, 'store'])->name('results.store');
        Route::get('/attendance/manage', [AttendanceController::class, 'manage'])->name('attendance.manage');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::post('/timetables/class', [TimetableController::class, 'storeClassTimetable'])->name('timetables.class.store');
        Route::post('/library/resources', [LibraryController::class, 'storeResource'])->name('library.resources.store');
    });

    /*
    |--------------------------------------------------------------------
    | School Admin - view everyone, edit nothing (except school-wide content
    | it is responsible for publishing: notices, fee structures, exam
    | timetables, enrollment review, book catalogue, payment verification).
    |--------------------------------------------------------------------
    */
    Route::middleware('role:school_admin')->group(function () {
        Route::get('/admin/students', [DirectoryController::class, 'students'])->name('directory.students');
        Route::get('/admin/teachers', [DirectoryController::class, 'teachers'])->name('directory.teachers');
        Route::get('/admin/school-admins', [DirectoryController::class, 'schoolAdmins'])->name('directory.school-admins');

        Route::get('/results/all', [ResultController::class, 'all'])->name('results.all');

        Route::post('/notices', [NoticeController::class, 'store'])->name('notices.store');

        Route::get('/fees/manage', [FeeController::class, 'manage'])->name('fees.manage');
        Route::post('/fees/structure', [FeeController::class, 'storeStructure'])->name('fees.structure.store');
        Route::post('/fees/payments/{payment}/verify', [FeeController::class, 'verifyPayment'])->name('fees.payments.verify');

        Route::post('/timetables/exam', [TimetableController::class, 'storeExamTimetable'])->name('timetables.exam.store');

        Route::post('/library/books', [LibraryController::class, 'storeBook'])->name('library.books.store');

        Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollment.index');
        Route::patch('/enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('enrollment.update');
    });
});

/*
|--------------------------------------------------------------------------
| System Administrator (owner) - separate guard, full edit access to
| everything and everyone.
|--------------------------------------------------------------------------
*/
Route::middleware('system.admin')->prefix('system-admin')->name('system-admin.')->group(function () {
    Route::get('/dashboard', [SystemAdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [SystemAdminAuthController::class, 'destroy'])->name('logout');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    Route::get('/results', [ResultController::class, 'all'])->name('results.all');
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
});
