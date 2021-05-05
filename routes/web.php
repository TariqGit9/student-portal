<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Auth::routes(['register' => false]);

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => 'checkAdmin'], function () {
        Route::get('/', 'AdminController@admin')->name('home');
        Route::get('classes', 'AdminController@classes')->name('classes');
        Route::post('add-class', 'AdminController@addClass')->name('add-class');
        Route::get('/get-classes', 'AdminController@getClasses')->name('get-classes');
        Route::post('del-class', 'AdminController@deleteClass')->name('del-class');
        //class Subjects
        Route::get('/class-subjects/{id}','AdminController@classSubjects')->name('class-subjects');
        
        //subjects
        Route::get('subjects', 'AdminController@subjects')->name('subjects');
        Route::post('add-subject', 'AdminController@addSubject')->name('add-subject');
        Route::any('/get-subject', 'AdminController@getSubjects')->name('get-subject');
        Route::post('edit-subject', 'AdminController@editSubject')->name('edit-subject');
        Route::post('del-subject', 'AdminController@deleteSubject')->name('del-subject');
        Route::post('get-subject-detail', 'AdminController@getSubjectDetail')->name('get-subject-detail');
        //grades 
        Route::get('grades', 'AdminController@grades')->name('grades');
        Route::get('/get-grades', 'AdminController@getGrades')->name('get-grades');
        Route::post('add-grade', 'AdminController@addGrade')->name('add-grade');
        Route::post('edit-grade', 'AdminController@editGrade')->name('edit-grade');
        Route::post('del-grade', 'AdminController@deleteGrade')->name('del-grade');
  
        //teachers
        Route::get('all-teachers', 'AdminController@teachers')->name('all-teachers');
        Route::post('add-teacher', 'AdminController@addTeacher')->name('add-teacher');
        Route::get('/get-teachers', 'AdminController@getTeachers')->name('get-teachers');
        Route::post('del-teacher', 'AdminController@deleteTeacher')->name('del-teacher');
        Route::post('edit-teacher', 'AdminController@editTeacher')->name('edit-teacher');
        Route::post('get-teacher-detail', 'AdminController@getTeacherDetail')->name('get-teacher-detail');
        //deletd Teachers
        Route::get('/get-deleted-teachers', 'AdminController@getDeletedTeachers')->name('get-deleted-teachers');
        Route::get('deleted-teachers', 'AdminController@deletedTeachers')->name('deleted-teachers');
        //Route::post('/get-deleted-teacher-detail', 'AdminController@getDeletedTeachers')->name('get-deleted-teacher-detail');
        Route::post('activate-teacher', 'AdminController@activateTeacher')->name('activate-teacher');
     
        //students
        Route::get('all-students', 'AdminController@students')->name('all-students');
        Route::post('add-student', 'AdminController@addStudent')->name('add-student');
        Route::any('/get-students', 'AdminController@getStudents')->name('get-students');
        Route::post('del-student', 'AdminController@deleteStudent')->name('del-student');
        Route::post('edit-student', 'AdminController@editStudent')->name('edit-student');
        Route::post('get-student-detail-admin', 'AdminController@getStudentDetail')->name('get-student-detail-admin');
        //deletd Students
        Route::get('/get-deleted-students', 'AdminController@getDeletedStudents')->name('get-deleted-students');
        Route::get('deleted-students', 'AdminController@deletedStudents')->name('deleted-students');
        Route::post('/get-deleted-student-detail', 'AdminController@getDeletedStudents')->name('get-deleted-student-detail');
        Route::post('activate-student', 'AdminController@activateStudent')->name('activate-student');
        //class Teachers
        Route::get('/class-teachers/{id}','AdminController@classTeachers')->name('class-teachers');
        Route::get('/get-subject-teacher', 'AdminController@getSubjectTeachers')->name('get-subject-teacher');
        //class Students
        Route::get('/class-students/{id}','AdminController@classStudents')->name('class-students');
        Route::post('/get-class-students', 'AdminController@getClassStudents')->name('get-class-students');
        //assignteacherToSubjectOfClass
        Route::post('assign-teacher-to-subject', 'AdminController@assignTeacherToSubject')->name('assign-teacher-to-subject');
       
        //Teacher Complaints of Students
        Route::get('teacher-complaints', 'AdminController@teacherComplaintsOfStudents')->name('teacher-complaints');
        Route::get('/get-teacher-complaints', 'AdminController@getTeacherComplaints')->name('get-teacher-complaints');
        
        Route::post('assign-teacher-to-subject', 'AdminController@assignTeacherToSubject')->name('assign-teacher-to-subject');
        Route::post('view-complain', 'AdminController@getComplainData')->name('view-complain');

    });

    Route::group(['namespace' => 'Student', 'prefix' => 'student','middleware' => 'checkStudent'], function () {
        Route::get('/', 'StudentController@student')->name('home');
        
    });
    Route::group(['namespace' => 'SuperAdmin', 'prefix' => 'super-admin','middleware' => 'checkSuperAdmin'], function () {
        Route::get('/', 'SuperAdminController@superAdmin')->name('home');
        Route::get('/all-schools', 'SuperAdminController@allSchools')->name('all-schools');
        Route::get('/get-schools', 'SuperAdminController@getSchools')->name('get-schools');
        Route::post('get-school-detail-super-admin', 'SuperAdminController@getSchoolDetail')->name('get-school-detail-super-admin');
        Route::post('add-school-superadmin', 'SuperAdminController@addSchool')->name('add-school-superadmin');
        Route::post('edit-school-superadmin', 'SuperAdminController@editSchool')->name('edit-school-superadmin');
        Route::post('block-school-super-admin', 'SuperAdminController@changeSchoolStatus')->name('block-school-super-admin');
        Route::any('view-all-school-users', 'SuperAdminController@allSchoolUsers')->name('view-all-school-users');
        Route::any('get-school-users', 'SuperAdminController@getSchoolUsers')->name('get-school-users');
        Route::post('block-user-super-admin', 'SuperAdminController@changeUserStatus')->name('block-user-super-admin');
        Route::any('get-user-details', 'SuperAdminController@getUserDetails')->name('get-user-details');
        Route::any('view-all-school-sessions', 'SuperAdminController@allSchoolSessions')->name('view-all-school-sessions');
        Route::post('get-school-session', 'SuperAdminController@getSchoolSessions')->name('get-school-session');


        Route::post('add-session', 'SuperAdminController@addSessions')->name('add-session');
        Route::post('change-school-session', 'SuperAdminController@changeSchoolSession')->name('change-school-session');
        // 
    });

    Route::group(['namespace' => 'Teacher', 'prefix' => 'teacher','middleware' => 'checkTeacher'], function () {
        Route::get('/', 'TeacherController@teacher')->name('home');
        Route::get('teacher-classes', 'TeacherController@teacherClass')->name('teacher-classes');
        Route::get('get-teacher-classes', 'TeacherController@getTeacherClass')->name('get-teacher-classes');
        Route::post('/get-teacher-class-students', 'TeacherController@getTeacherClassStudent')->name('get-teacher-class-students');
        Route::any('/teacher-class-students', 'TeacherController@teacherClassStudent')->name('teacher-class-students');
        Route::post('get-student-detail', 'TeacherController@getStudentDetail')->name('get-student-detail');
        Route::any('/teacher-insert-student-marks', 'TeacherController@teacherInsertStudentMarks')->name('teacher-insert-student-marks');
        Route::post('add-student-result', 'TeacherController@addStudentResult')->name('add-student-result');
        Route::any('class-student-results', 'TeacherController@classStudentResults')->name('class-student-results');
        Route::post('get-class-assesments', 'TeacherController@getClassAssesments')->name('get-class-assesments');
    //
        Route::post('toggle-assessments-status', 'TeacherController@toggleAssessmentsStatus')->name('toggle-assessments-status');
        Route::any('assesment-class-student', 'TeacherController@assesmentClassStudent')->name('assesment-class-student');
        Route::post('get-class-assesments-result', 'TeacherController@getClassAssesmentsResults')->name('get-class-assesments-result');


        Route::post('report-student-to-admin', 'TeacherController@reportStudentToAdmin')->name('report-student-to-admin');
        Route::post('edit-marks', 'TeacherController@editMarks')->name('edit-marks');
    
    });
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
