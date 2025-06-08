<?php

use App\Http\Controllers\DatabaseCandidateController;
use App\Http\Controllers\GlobalCandidateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OfferingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TasklistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferingManagmentController;
use App\Http\Controllers\RequesterController;
use App\Http\Controllers\OnboardingController;
use Illuminate\Notifications\Notification;

Route::get('/api/user',[LoginController::class, 'user'])->name('user');

Route::get('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/', [LoginController::class, 'view'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/', [LoginController::class, 'login']);

//dashboardhr
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/dashboardhr/getResource', [DashboardController::class, 'getResource'])->name('getResource')->middleware('auth');
Route::get('/dashboardhr/getRecruiter/{resourceId}', [DashboardController::class, 'getDashboardHr'])->name('getDashboardHr')->middleware('auth');

//dashboardrecruiter
Route::get('/dashboard/recruiter', [DashboardController::class, 'dashboardrecruiter'])->name('dashboardrecruiter')->middleware('auth');
Route::get('/dashboard/recruiter/getResource', [DashboardController::class, 'getResourceRecruiter'])->name('getResource')->middleware('auth');
Route::get('/dashboard/positon/{resourceId}', [DashboardController::class, 'getPosition'])->name('dashboardGetPosition')->middleware('auth');

//dashboardmanagement
Route::get('/dashboard/management', [DashboardController::class, 'dashboardmanagement'])->name('dashboardmanagement')->middleware('auth');

Route::get(uri: '/requester', action: [RequesterController::class, 'requester'])->name(name: 'requester')->middleware('auth');
Route::post('/requester', [RequesterController::class, 'addResource'])->name('addResource');
Route::get('/requester/{id}', [RequesterController::class, 'detailRequester'])->name('detailRequester')->middleware('auth');
Route::get('/requester/updated/{id}', [RequesterController::class, 'updateRequester'])->name('updateRequester')->middleware('auth');
Route::post('/requester/save/{id}', [RequesterController::class, 'saveRequester'])->name('saveRequester')->middleware('auth');
Route::get('/tasklist', action: [TasklistController::class, 'tasklist'])->name('tasklist')->middleware('auth');

//databaseCandidate
Route::get('/candidateDatabase', action: [DatabaseCandidateController::class, 'candidateDatabase'])->name('candidateDatabase')->middleware('auth');
Route::post('/candidateDatabase', [DatabaseCandidateController::class, 'addCandidate'])->name('addCandidate');
Route::get('/candidateDatabase/{id}', action: [DatabaseCandidateController::class, 'detailCandidate'])->name('detailCandidate')->middleware('auth');
Route::get('/candidateDatabase/updatedCandidate/{id}', action: [DatabaseCandidateController::class, 'updateCandidate'])->name('updateCandidate')->middleware('auth');
Route::post('/candidateDatabase/saveCandidate/{id}', action: [DatabaseCandidateController::class, 'saveCandidate'])->name('saveCandidate')->middleware('auth');
Route::get('/candidateDatabase/unFavouriteCandidate/{id}', action: [DatabaseCandidateController::class, 'unFavouriteCandidate'])->name('unFavouriteCandidate')->middleware('auth');
Route::get('/candidateDatabase/inFavouriteCandidate/{id}', action: [DatabaseCandidateController::class, 'inFavouriteCandidate'])->name('inFavouriteCandidate')->middleware('auth');
Route::get('/requestCandidate/{id}', action: [DatabaseCandidateController::class, 'requestCandidate'])->name('requestCandidate')->middleware('auth');

//globalCandidate
Route::get('/globalCandidate', action: [GlobalCandidateController::class, 'globalCandidate'])->name('globalCandidate')->middleware('auth');
Route::post('/globalCandidate', [GlobalCandidateController::class, 'addCandidate'])->name('addCandidate');
Route::get('/globalCandidate/{id}', action: [GlobalCandidateController::class, 'detailGlobal'])->name('detailGlobal')->middleware('auth');
Route::get('/globalCandidate/updatedCandidate/{id}', action: [GlobalCandidateController::class, 'updateCandidate'])->name('updateCandidate')->middleware('auth');
Route::post('/globalCandidate/saveCandidate/{id}', action: [GlobalCandidateController::class, 'saveCandidate'])->name('saveCandidate')->middleware('auth');
Route::get('/globalCandidate/unFavouriteCandidate/{id}', action: [GlobalCandidateController::class, 'unFavouriteCandidate'])->name('unFavouriteCandidate')->middleware('auth');
Route::get('/globalCandidate/inFavouriteCandidate/{id}', action: [GlobalCandidateController::class, 'inFavouriteCandidate'])->name('inFavouriteCandidate')->middleware('auth');
Route::get('/requestGlobalCandidate/{id}', action: [GlobalCandidateController::class, 'requestGlobalCandidate'])->name('requestGlobalCandidate')->middleware('auth');



Route::post('/resourceDetail', [DatabaseCandidateController::class, 'getPositionsByResource'])->name('getPositions')->middleware('auth');

Route::post('/interview', [InterviewController::class, 'addInterview'])->name('addInterview')->middleware('auth');
Route::get('/interview', [InterviewController::class, 'view'])->name('interview')->middleware('auth');
Route::get('/interview/detail/{id}', [InterviewController::class, 'detailInterview'])->name('detailInterview')->middleware('auth');
Route::get('/interview/updated/{id}', [InterviewController::class, 'updateInterview'])->name('updateInterview')->middleware('auth');
Route::post('/interview/save/{id}', [InterviewController::class, 'saveInterview'])->name('saveInterview')->middleware('auth');

//offering
Route::get('/offering', action: [OfferingController::class, 'offering'])->name('offering')->middleware('auth');
Route::post('/offering/addApporval/{id}', action: [OfferingController::class, 'addApproval'])->name('addApproval')->middleware('auth');
Route::get('/offering/detail/{id}', [OfferingController::class, 'detailOffering'])->name('detailOffering')->middleware('auth');
Route::get('/offering/update/{id}', [OfferingController::class, 'updatedOffering'])->name('updateOffering')->middleware('auth');
Route::post('/offering/save/{id}', [OfferingController::class, 'saveOffering'])->name('saveOffering')->middleware('auth');

//offeringManagement
Route::get('/offeringManagement', action: [OfferingManagmentController::class, 'offeringManagement'])->name('offeringManagement')->middleware('auth');
Route::post('/offeringManagement/addApporval/{id}', action: [OfferingManagmentController::class, 'addApproval'])->name('addApproval')->middleware('auth');
Route::get('/offeringManagement/detail/{id}', [OfferingManagmentController::class, 'detailOfferingManagement'])->name('detailofferingManagement')->middleware('auth');
Route::get('/offeringManagement/update/{id}', [OfferingManagmentController::class, 'updatedOfferingManagement'])->name('updateOfferingManagement')->middleware('auth');
Route::post('/offeringManagement/save/{id}', [OfferingManagmentController::class, 'saveOfferingManagement'])->name('saveOfferingManagement')->middleware('auth');

Route::post('/onboarding/add/{id}', [OnboardingController::class, 'addOnboarding'])->name('addOnboarding')->middleware('auth');
Route::get('/onboarding', [OnboardingController::class, 'onboarding'])->name('onboarding')->middleware('auth');
Route::get('/onboarding/update/{id}', [OnboardingController::class, 'updateOnboarding'])->name('updateOnboarding')->middleware('auth');
Route::put('/onboarding/save/{id}', [OnboardingController::class, 'saveOnboarding'])->name('saveOnboarding')->middleware('auth');
Route::get('/onboarding/detail/{id}', [OnboardingController::class, 'detailOnboarding'])->name('detailOnboarding')->middleware('auth');
Route::post('/onboarding/sendhrm/{id}', [OnboardingController::class, 'sendHrm'])->name('sendHrm')->middleware('auth');
Route::post('/onboarding/cancel/{id}', [OnboardingController::class, 'cancelOnboarding'])->name('cancelOnboarding')->middleware('auth');

Route::put('/notification/readall', [NotificationController::class,'read_all'])->name('readAllNotification')->middleware('auth');
Route::put('/notification/accept/{id}', [NotificationController::class,'accept'])->name('acceptNotification')->middleware('auth');
Route::put('/notification/reject/{id}', [NotificationController::class,'reject'])->name('rejectNotification')->middleware('auth');
 