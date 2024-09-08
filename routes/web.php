<?php

use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\manageEmployeeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\viewEmployeeController;
use Illuminate\Support\Facades\Route;



Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');


// Admin Routes (Accessible only by admin users)
//  Route::group(['middleware' => ['auth']], function () {
//     Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
// });
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');






Route::get('/', [HomeController::class, 'home'])->name('home');


Route::post('/login-form', [UserController::class, 'loginPost'])->name('admin.login.post');



// Admin Routes (Accessible only by admin users)
// Route::group(['middleware' => ['auth', 'IsAdmin']], function () {
// department


Route::get('/myProfile', [UserController::class, 'myProfile'])->name('profile');

Route::get('/organization/department', [OrganizationController::class, 'department'])->name('organization.department');

Route::get('/Organization/department', [OrganizationController::class, 'member'])->name('organization.member');

Route::post('/Organization/department/member/store', [OrganizationController::class, 'memberStore'])->name('organization.department.member.store');


Route::get('/Organization/share', [OrganizationController::class, 'share'])->name('organization.share');

Route::put('/shares/transfer/{id}', [OrganizationController::class, 'transferShares'])->name('shares.transfer');


Route::post('/Organization/shareStore', [OrganizationController::class, 'shareStore'])->name('organization.shareStore');

Route::get('/share/edit/{id}', [OrganizationController::class, 'shareEdit'])->name('share.edit');

Route::put('/share/shareUpdate/{id}', [OrganizationController::class, 'shareUpdate'])->name('share.shareUpdate');

Route::get('/share/delete/{id}', [OrganizationController::class, 'shareDelete'])->name('share.delete');

Route::get('/Organization/properties', [OrganizationController::class, 'properties'])->name('organization.properties');

Route::post('/properties/propertyStore', [OrganizationController::class, 'propertyStore'])->name('property.propertyStore');

Route::get('/properties/propertyEdit/{id}', [OrganizationController::class, 'propertyEdit'])->name('property.propertyEdit');

Route::put('/properties/propertyUpdate/{id}', [OrganizationController::class, 'propertyUpdate'])->name('property.propertyUpdate');

Route::get('/properties/deleteProperty/{id}', [OrganizationController::class, 'deleteProperty'])->name('property.deleteProperty');




Route::get('/Organization/meeting', [OrganizationController::class, 'meeting'])->name('organization.meeting');

Route::post('/meeting/meetingStore', [OrganizationController::class, 'meetingStore'])->name('meeting.meetingStore');

Route::get('/meeting/meetingEdit/{id}', [OrganizationController::class, 'meetingEdit'])->name('meeting.meetingEdit');

Route::put('/meeting/meetingUpdate/{id}', [OrganizationController::class, 'meetingUpdate'])->name('meeting.meetingUpdate');

Route::get('/meeting/deletemeeting/{id}', [OrganizationController::class, 'deleteMeeting'])->name('meeting.deleteMeeting');



Route::get('/Organization/punishment', [OrganizationController::class, 'punishment'])->name('organization.punishment');
Route::post('/punishment/punishmentStore', [OrganizationController::class, 'punishmentStore'])->name('punishment.punishmentStore');
Route::get('/punishment/punishmentEdit/{id}', [OrganizationController::class, 'punishmentEdit'])->name('punishment.punishmentEdit');
Route::put('/punishment/punishmentUpdate/{id}', [OrganizationController::class, 'punishmentUpdate'])->name('punishment.punishmentUpdate');
Route::get('/punishment/Deletepunishment/{id}', [OrganizationController::class, 'Deletepunishment'])->name('punishment.Deletepunishment');






Route::get('/Organization/expendutureCategory', [OrganizationController::class, 'expendutureCategory'])->name('organization.expendutureCategory');
Route::post('/expendutureCategory/expendutureCategoryStore', [OrganizationController::class, 'expendutureCategoryStore'])->name('organization.expendutureCategoryStore');
Route::get('/expendutureCategory/expendutureCategoryEdit/{id}', [OrganizationController::class, 'expendutureCategoryEdit'])->name('organization.expendutureCategoryEdit');
Route::put('/expendutureCategory/expendutureCategoryUpdate/{id}', [OrganizationController::class, 'expendutureCategoryUpdate'])->name('organization.expendutureCategoryUpdate');
Route::get('/expendutureCategory/expendutureCategoryDelete{id}', [OrganizationController::class, 'expendutureCategoryDelete'])->name('organization.expendutureCategoryDelete');


Route::get('/Organization/expenduture', [OrganizationController::class, 'expenduture'])->name('organization.expenduture');

Route::post('/expenduture/expendutureStore', [OrganizationController::class, 'expendutureStore'])->name('expenduture.expendutureStore');

Route::get('/expenduture/expendutureEdit/{id}', [OrganizationController::class, 'expendutureEdit'])->name('expenduture.expendutureEdit');

Route::put('/expenduture/expendutureUpdate/{id}', [OrganizationController::class, 'expendutureUpdate'])->name('expenduture.expendutureUpdate');

Route::get('/expenduture/expendutureDelete/{id}', [OrganizationController::class, 'expendutureDelete'])->name('expenduture.expendutureDelete');


Route::get('/Organization/agent', [OrganizationController::class, 'agent'])->name('organization.agent');
Route::post('/agent/agentStore', [OrganizationController::class, 'agentStore'])->name('agent.agentStore');
Route::get('/agent/agentEdit/{id}', [OrganizationController::class, 'agentEdit'])->name('agent.agentEdit');
Route::put('/agent/agentUpdate/{id}', [OrganizationController::class, 'agentUpdate'])->name('agent.agentUpdate');
Route::get('/agent/agentDelete/{id}', [OrganizationController::class, 'agentDelete'])->name('agent.agentDelete');




Route::get('/Organization/agentProfit', [OrganizationController::class, 'agentProfit'])->name('organization.agentProfit');

Route::post('/Organization/agentProfitStore', [OrganizationController::class, 'agentProfitStore'])->name('organization.agentProfitStore');

Route::get('/Organization/agentProfitEdit/{id}', [OrganizationController::class, 'agentProfitEdit'])->name('organization.agentProfitEdit');

Route::put('/Organization/agentProfitUpdate/{id}', [OrganizationController::class, 'agentProfitUpdate'])->name('organization.agentProfitUpdate');

Route::get('/Organization/agentProfitDelete/{id}', [OrganizationController::class, 'agentProfitDelete'])->name('organization.agentProfitDelete');
























Route::post('/Organization/department/store', [OrganizationController::class, 'store'])->name('organization.department.store');






Route::get('/Organization/delete/{id}', [OrganizationController::class, 'delete'])->name('Organization.delete');
Route::get('/Organization/edit/{id}', [OrganizationController::class, 'edit'])->name('Organization.edit');
Route::put('/Organization/update/{id}', [OrganizationController::class, 'update'])->name('Organization.update');
Route::get('/Organization/Search/Department', [OrganizationController::class, 'searchDepartment'])->name('searchDepartment');




// designation
Route::get('/Organization/designation', [DesignationController::class, 'designation'])->name('organization.designation');
Route::post('/Organization/designation/store', [DesignationController::class, 'designationStore'])->name('organization.designation.store');
Route::get('/Organization/designationList', [DesignationController::class, 'designationList'])->name('organization.designationList');
Route::get('/designation/delete/{id}', [DesignationController::class, 'delete'])->name('designation.delete');
Route::get('/designation/edit/{id}', [DesignationController::class, 'edit'])->name('designation.edit');
Route::put('/Designation/update/{id}', [DesignationController::class, 'update'])->name('Designation.update');
Route::get('/Designation/Search/Designation', [DesignationController::class, 'searchDesignation'])->name('searchDesignation');


// Leave
Route::get('/Loan/loanStatus', [LeaveController::class, 'LoanList'])->name('loan.loanStatus');

Route::get('/Loan/paymentHistory', [LeaveController::class, 'paymentHistory'])->name('loan.paymentHistory');

Route::get('/Leave/allLeaveReport', [LeaveController::class, 'allLeaveReport'])->name('allLeaveReport');
Route::get('/searchLeaveList', [LeaveController::class, 'searchLeaveList'])->name('searchLeaveList');

// Approve,, Reject Leaveorganization.designationList
Route::get('/leave/approve/{id}',  [LeaveController::class, 'approveLeave'])->name('leave.approve');
Route::get('/leave/reject/{id}',  [LeaveController::class, 'rejectLeave'])->name('leave.reject');

// Leave Type
Route::get('/Leave/LeaveType', [LeaveController::class, 'leaveType'])->name('leave.leaveType');
Route::post('/Leave/LeaveType/store', [LeaveController::class, 'leaveStore'])->name('leave.leaveType.store');
Route::get('/LeaveType/delete/{id}', [LeaveController::class, 'LeaveDelete'])->name('leave.leaveType.delete');
Route::get('/LeaveType/edit/{id}', [LeaveController::class, 'leaveEdit'])->name('leave.leaveType.edit');
Route::put('/designation/update/{id}', [LeaveController::class, 'LeaveUpdate'])->name('leave.leaveType.update');


// User updated
Route::get('/users', [UserController::class, 'list'])->name('users.list');
Route::get('/users/create/{employeeId}', [UserController::class, 'createForm'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'userProfile'])->name('users.profile.view');
Route::get('/user/delete/{id}', [UserController::class, 'userDelete'])->name('delete');
Route::get('/user/edit/{id}', [UserController::class, 'userEdit'])->name('edit');
Route::put('/user/update/{id}', [UserController::class, 'userUpdate'])->name('update');
Route::get('/search-user', [UserController::class, 'searchUser'])->name('searchUser');

// message info
Route::get('/contactUs/Message', [HomeController::class, 'message'])->name('message');
// });


// Employee route

// Route::group(['middleware' => ['auth', 'IsEmployee']], function () {


// Leave Routes for Employee
Route::get('/loan/loanForm', [LoanController::class, 'loan'])->name('loan.loanForm');
Route::post('/Leave/store', [LoanController::class, 'store'])->name('leave.store');
Route::get('/Leave/myLeave', [LeaveController::class, 'myLeave'])->name('leave.myLeave');

Route::get('/Leave/details/{id}', [LeaveController::class, 'getLoanDetails'])->name('leave.details');

Route::post('/Leave/payment/{id}', [LeaveController::class, 'payment'])->name('payment.store');




Route::get('/Leave/myLeaveReport', [LeaveController::class, 'myLeaveReport'])->name('myLeaveReport');
Route::get('/searchMyLeave', [LeaveController::class, 'searchMyLeave'])->name('searchMyLeave');
// user profile
Route::get('/myProfile', [UserController::class, 'myProfile'])->name('profile');

Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');


// });


// Employee Management
Route::get('/Employee/addEmployee', [manageEmployeeController::class, 'addEmployee'])->name('manageEmployee.addEmployee');
Route::post('/manageEmployee/addEmployee/store', [manageEmployeeController::class, 'store'])->name('manageEmployee.addEmployee.store');
Route::get('/Employee/viewEmployee', [viewEmployeeController::class, 'viewEmployee'])->name('manageEmployee.ViewEmployee');
Route::get('/Employee/delete/{id}', [viewEmployeeController::class, 'delete'])->name('Employee.delete');
Route::get('Employee/edit/{id}', [viewEmployeeController::class, 'edit'])->name('Employee.edit');
Route::put('/Employee/update/{id}', [viewEmployeeController::class, 'update'])->name('Employee.update');
Route::get('/Employee/profile/{id}', [viewEmployeeController::class, 'profile'])->name('Employee.profile');
Route::get('/search-employee', [viewEmployeeController::class, 'search'])->name('employee.search');
