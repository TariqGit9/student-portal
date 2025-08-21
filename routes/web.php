<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();
Auth::routes(['register' => false]);

    Route::group(['middleware' => 'auth'], function () {

        Route::post('change-user-password', [HomeController::class, 'changeUserPassword'])->name('change-user-password');

        Route::group(['prefix' => 'admin','middleware' => 'checkAdmin'], function () {
        Route::get('/', [AdminController::class, 'admin'])->name('home');
        Route::get('classes', [AdminController::class, 'classes'])->name('classes');
        Route::post('add-class', [AdminController::class, 'addClass'])->name('add-class');
        Route::get('/get-classes', [AdminController::class, 'getClasses'])->name('get-classes');
        Route::post('del-class', [AdminController::class, 'deleteClass'])->name('del-class');
        //class Subjects
        Route::get('/class-subjects/{id}',[AdminController::class, 'classSubjects'])->name('class-subjects');
        
        //subjects
        Route::get('subjects', [AdminController::class, 'subjects'])->name('subjects');
        Route::post('add-subject', [AdminController::class, 'addSubject'])->name('add-subject');
        Route::any('/get-subject', [AdminController::class, 'getSubjects'])->name('get-subject');
        Route::post('edit-subject', [AdminController::class, 'editSubject'])->name('edit-subject');
        Route::post('del-subject', [AdminController::class, 'deleteSubject'])->name('del-subject');
        Route::post('get-subject-detail', [AdminController::class, 'getSubjectDetail'])->name('get-subject-detail');

        Route::any('/get-subject-for-managment', [AdminController::class, 'getSubjectforManagment'])->name('get-subject-for-managment');
        Route::post('admin-get-student-subject-attendance', [AdminController::class, 'getStudentsSubjectAttendance'])->name('admin-get-student-subject-attendance');
        
        //grades 
        Route::get('grades', [AdminController::class, 'grades'])->name('grades');
        Route::get('/get-grades', [AdminController::class, 'getGrades'])->name('get-grades');
        Route::post('add-grade', [AdminController::class, 'addGrade'])->name('add-grade');
        Route::post('edit-grade', [AdminController::class, 'editGrade'])->name('edit-grade');
        Route::post('del-grade', [AdminController::class, 'deleteGrade'])->name('del-grade');
  
        //teachers
        Route::get('all-teachers', [AdminController::class, 'teachers'])->name('all-teachers');
        Route::post('add-teacher', [AdminController::class, 'addTeacher'])->name('add-teacher');
        Route::get('/get-teachers', [AdminController::class, 'getTeachers'])->name('get-teachers');
        Route::post('del-teacher', [AdminController::class, 'deleteTeacher'])->name('del-teacher');
        Route::post('edit-teacher', [AdminController::class, 'editTeacher'])->name('edit-teacher');
        Route::post('get-teacher-detail', [AdminController::class, 'getTeacherDetail'])->name('get-teacher-detail');
        //deletd Teachers
        Route::get('/get-deleted-teachers', [AdminController::class, 'getDeletedTeachers'])->name('get-deleted-teachers');
        Route::get('deleted-teachers', [AdminController::class, 'deletedTeachers'])->name('deleted-teachers');
        //Route::post('/get-deleted-teacher-detail', [AdminController::class, 'getDeletedTeachers'])->name('get-deleted-teacher-detail');
        Route::post('activate-teacher', [AdminController::class, 'activateTeacher'])->name('activate-teacher');
     
        //students
        Route::get('all-students', [AdminController::class, 'students'])->name('all-students');
        Route::post('add-student', [AdminController::class, 'addStudent'])->name('add-student');
        Route::any('/get-students', [AdminController::class, 'getStudents'])->name('get-students');
        Route::post('del-student', [AdminController::class, 'deleteStudent'])->name('del-student');
        Route::post('edit-student', [AdminController::class, 'editStudent'])->name('edit-student');
        Route::post('get-student-detail-admin', [AdminController::class, 'getStudentDetail'])->name('get-student-detail-admin');
        //deletd Students
        Route::get('/get-deleted-students', [AdminController::class, 'getDeletedStudents'])->name('get-deleted-students');
        Route::get('deleted-students', [AdminController::class, 'deletedStudents'])->name('deleted-students');
        Route::post('/get-deleted-student-detail', [AdminController::class, 'getDeletedStudents'])->name('get-deleted-student-detail');
        Route::post('activate-student', [AdminController::class, 'activateStudent'])->name('activate-student');
        //class Teachers
        Route::get('/class-teachers/{id}',[AdminController::class, 'classTeachers'])->name('class-teachers');
        Route::get('/get-subject-teacher', [AdminController::class, 'getSubjectTeachers'])->name('get-subject-teacher');
        //class Students
        Route::get('/class-students/{id}',[AdminController::class, 'classStudents'])->name('class-students');
        Route::post('/get-class-students', [AdminController::class, 'getClassStudents'])->name('get-class-students');
        //assignteacherToSubjectOfClass
        Route::post('assign-teacher-to-subject', [AdminController::class, 'assignTeacherToSubject'])->name('assign-teacher-to-subject');
        Route::post('change-student-password', [AdminController::class, 'changeStudentPassword'])->name('change-student-password');

        //Teacher Complaints of Students
        Route::get('teacher-complaints', [AdminController::class, 'teacherComplaintsOfStudents'])->name('teacher-complaints');
        Route::get('/get-teacher-complaints', [AdminController::class, 'getTeacherComplaints'])->name('get-teacher-complaints');
        
        Route::post('assign-teacher-to-subject', [AdminController::class, 'assignTeacherToSubject'])->name('assign-teacher-to-subject');
        Route::post('view-complain', [AdminController::class, 'getTeacherComplainData'])->name('view-complain');
        Route::post('change-complain-status-teacher', [AdminController::class, 'changeComplainStatusTeacher'])->name('change-complain-status-teacher');
        
        
        Route::get('students-complaints', [AdminController::class, 'StudentsComplaintsOfTeacher'])->name('students-complaints');
        Route::get('/get-students-complaints', [AdminController::class, 'getStudentsComplaints'])->name('get-students-complaints');
        Route::post('view-complain-student', [AdminController::class, 'getStudentComplainData'])->name('view-complain-student');
        Route::post('change-complain-status-student', [AdminController::class, 'changeComplainStatusStudent'])->name('change-complain-status-student');
       
        Route::any('marks-types', [AdminController::class, 'getResultTypes'])->name('marks-types');
        Route::get('get-result-types', [AdminController::class, 'getSchoolResultTypes'])->name('get-result-types');

        Route::post('add-result-type', [AdminController::class, 'addResultType'])->name('add-result-type');
        Route::post('edit-result-type', [AdminController::class, 'editResultType'])->name('edit-result-type');
        Route::post('change-result-type-status', [AdminController::class, 'changeResultTypeStatus'])->name('change-result-type-status'); 
        

        Route::get('/all-branches', [AdminController::class, 'allBranches'])->name('all-branches');
        Route::get('/get-branches', [AdminController::class, 'getBranches'])->name('get-branches');
        Route::post('get-branch-detail-admin', [AdminController::class, 'getBranchDetail'])->name('get-branch-detail-admin');
        Route::post('add-branch-admin', [AdminController::class, 'addBranch'])->name('add-branch-admin');
        Route::post('edit-branch-admin', [AdminController::class, 'editBranch'])->name('edit-branch-admin');
        Route::post('change-school-branch', [AdminController::class, 'changeSchoolBranch'])->name('change-school-branch');
        Route::any('admin-get-student-subject-attendance', [AdminController::class, 'getStudentsSubjectAttendance'])->name('admin-get-student-subject-attendance');
        Route::any('class-subject-managment/{id}', [AdminController::class, 'classSubjectManagment'])->name('class-subject-managment');

        Route::post('view-student-attendance', [AdminController::class, 'studentAttendance'])->name('view-student-attendance');
        Route::post('get-student-subject-attendance-admin', [AdminController::class, 'getStudentSubjectAttendance'])->name('get-student-subject-attendance-admin');

        Route::post('get-student-subject-attendance-admin-stats', [AdminController::class, 'getStudentAttendanceStats'])->name('get-student-subject-attendance-admin-stats');
        
        Route::post('student-marks-admin', [AdminController::class, 'studentMarks'])->name('student-marks-admin');
        Route::post('display-student-marks-admin', [AdminController::class, 'getStudentMarks'])->name('display-student-marks-admin');

        // Fee Management Routes
        Route::get('fees', [App\Http\Controllers\Admin\FeeController::class, 'index'])->name('admin.fees');
        Route::get('get-fees', [App\Http\Controllers\Admin\FeeController::class, 'getFees'])->name('admin.get-fees');
        Route::post('add-fee', [App\Http\Controllers\Admin\FeeController::class, 'store'])->name('admin.add-fee');
        Route::post('update-fee', [App\Http\Controllers\Admin\FeeController::class, 'update'])->name('admin.update-fee');
        Route::post('delete-fee', [App\Http\Controllers\Admin\FeeController::class, 'destroy'])->name('admin.delete-fee');
        Route::get('fee-students/{id}', [App\Http\Controllers\Admin\FeeController::class, 'studentFees'])->name('admin.fee.students');
        Route::get('get-student-fees', [App\Http\Controllers\Admin\FeeController::class, 'getStudentFees'])->name('admin.get-student-fees');
        Route::post('record-payment', [App\Http\Controllers\Admin\FeeController::class, 'recordPayment'])->name('admin.record-payment');
        Route::get('payment-history/{id}', [App\Http\Controllers\Admin\FeeController::class, 'paymentHistory'])->name('admin.payment-history');
        Route::get('fee-report', [App\Http\Controllers\Admin\FeeController::class, 'feeReport'])->name('admin.fee.report');

    });


    Route::group(['prefix' => 'super-admin','middleware' => 'checkSuperAdmin'], function () {
        Route::get('/', [SuperAdminController::class, 'superAdmin'])->name('home');
        Route::get('/all-schools', [SuperAdminController::class, 'allSchools'])->name('all-schools');
        Route::get('/get-schools', [SuperAdminController::class, 'getSchools'])->name('get-schools');
        Route::post('get-school-detail-super-admin', [SuperAdminController::class, 'getSchoolDetail'])->name('get-school-detail-super-admin');
        Route::post('add-school-superadmin', [SuperAdminController::class, 'addSchool'])->name('add-school-superadmin');
        Route::post('edit-school-superadmin', [SuperAdminController::class, 'editSchool'])->name('edit-school-superadmin');
        Route::post('block-school-super-admin', [SuperAdminController::class, 'changeSchoolStatus'])->name('block-school-super-admin');
        Route::any('view-all-school-users', [SuperAdminController::class, 'allSchoolUsers'])->name('view-all-school-users');
        Route::any('get-school-users', [SuperAdminController::class, 'getSchoolUsers'])->name('get-school-users');
        Route::post('block-user-super-admin', [SuperAdminController::class, 'changeUserStatus'])->name('block-user-super-admin');
        Route::any('get-user-details', [SuperAdminController::class, 'getUserDetails'])->name('get-user-details');
        Route::any('view-all-school-sessions', [SuperAdminController::class, 'allSchoolSessions'])->name('view-all-school-sessions');
        Route::post('get-school-session', [SuperAdminController::class, 'getSchoolSessions'])->name('get-school-session');
        // 

        Route::post('add-session', [SuperAdminController::class, 'addSessions'])->name('add-session');
        Route::post('change-school-session', [SuperAdminController::class, 'changeSchoolSession'])->name('change-school-session');

    });

    Route::group(['prefix' => 'teacher','middleware' => 'checkTeacher'], function () {
        Route::get('/', [TeacherController::class, 'teacher'])->name('home');
        Route::get('teacher-classes', [TeacherController::class, 'teacherClass'])->name('teacher-classes');
        Route::get('get-teacher-classes', [TeacherController::class, 'getTeacherClass'])->name('get-teacher-classes');
        Route::post('/get-teacher-class-students', [TeacherController::class, 'getTeacherClassStudent'])->name('get-teacher-class-students');
        Route::any('/teacher-class-students', [TeacherController::class, 'teacherClassStudent'])->name('teacher-class-students');
        Route::post('get-student-detail', [TeacherController::class, 'getStudentDetail'])->name('get-student-detail');
        Route::any('/teacher-insert-student-marks', [TeacherController::class, 'teacherInsertStudentMarks'])->name('teacher-insert-student-marks');
        Route::post('add-student-result', [TeacherController::class, 'addStudentResult'])->name('add-student-result');
        Route::any('class-student-results', [TeacherController::class, 'classStudentResults'])->name('class-student-results');
        Route::post('get-class-assesments', [TeacherController::class, 'getClassAssesments'])->name('get-class-assesments');
    //
        Route::post('toggle-assessments-status', [TeacherController::class, 'toggleAssessmentsStatus'])->name('toggle-assessments-status');
        Route::any('assesment-class-student', [TeacherController::class, 'assesmentClassStudent'])->name('assesment-class-student');
        Route::post('get-class-assesments-result', [TeacherController::class, 'getClassAssesmentsResults'])->name('get-class-assesments-result');
        Route::post('report-student-to-admin', [TeacherController::class, 'reportStudentToAdmin'])->name('report-student-to-admin');
        Route::post('student-marks', [TeacherController::class, 'studentMarks'])->name('student-marks');
        Route::post('display-student-marks', [TeacherController::class, 'getStudentMarks'])->name('display-student-marks');
        Route::post('view-student-attendance', [TeacherController::class, 'studentAttendance'])->name('view-student-attendance');
        Route::post('edit-marks', [TeacherController::class, 'editMarks'])->name('edit-marks');
        Route::any('/teacher-insert-student-attendance', [TeacherController::class, 'teacherInsertStudentAttendance'])->name('teacher-insert-student-attendance');
        Route::post('add-student-attendance', [TeacherController::class, 'addStudentattendance'])->name('add-student-attendance');
        Route::post('get-student-subject-attendance', [TeacherController::class, 'getStudentsSubjectAttendance'])->name('get-student-subject-attendance');
        Route::post('get-student-subject-attendance-teacher', [TeacherController::class, 'getStudentSubjectAttendance'])->name('get-student-subject-attendance-teacher');
        Route::post('get-student-subject-attendance-teacher-stats', [TeacherController::class, 'getStudentAttendanceStats'])->name('get-student-subject-attendance-teacher-stats');
        



    });

    Route::group(['prefix' => 'student','middleware' => 'checkStudent'], function () {
        Route::get('/', [StudentController::class, 'student'])->name('home');
      
        Route::get('show-user-detail/{{id}}', [StudentController::class, 'student'])->name('show-user-detail');
        Route::get('get-class-teacher-student', [StudentController::class, 'getClassTeachers'])->name('get-class-teacher-student');
        Route::get('my-marks', [StudentController::class, 'studentMarks'])->name('my-marks');
        Route::get('teachers', [StudentController::class, 'studentTeachers'])->name('teachers');
        Route::post('get-student-marks', [StudentController::class, 'getStudentMarks'])->name('get-student-marks');
        Route::get('my-attendance', [StudentController::class, 'studentAttendance'])->name('my-attendance');
        Route::post('report-teacher-to-admin', [StudentController::class, 'reportTeacherToAdmin'])->name('report-teacher-to-admin');
        
        Route::post('get-my-subject-attendance', [StudentController::class, 'getStudentSubjectAttendance'])->name('get-my-subject-attendance');

        Route::post('get-my-subject-attendance-stats', [StudentController::class, 'getStudentAttendanceStats'])->name('get-my-subject-attendance-stats');
        
        // Student Fee Routes
        Route::get('my-fees', [StudentController::class, 'myFees'])->name('student.fees');
        Route::get('fee-details/{id}', [StudentController::class, 'feeDetails'])->name('student.fee.details');
    });
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
