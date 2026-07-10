<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RevisorController;
use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\UserIsOwner;
use App\Http\Middleware\UserIsRevisor;
use App\Http\Middleware\UserIsWriter;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/', [PublicController::class, 'homepage'])->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/work-with-us', [JobApplicationController::class, 'showForm'])->name('work.with.us');
    Route::get('/lavora-con-noi', [JobApplicationController::class, 'showForm'])->name('job.form');
    Route::post('/lavora-con-noi', [JobApplicationController::class, 'submitApplication'])->name('job.submit');
    Route::get('/job-applications/{application}/cv', [JobApplicationController::class, 'downloadCv'])->name('jobApplications.cv.download');
});

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/articles/category/{category}', [ArticleController::class, 'byCategory'])
    ->where('category', '[0-9]+')
    ->name('article.byCategory');

Route::get('/articles/user/{user}', [ArticleController::class, 'byUser'])
    ->where('user', '[0-9]+')
    ->name('article.byUser');

Route::middleware(['auth', UserIsRevisor::class])->group(function () {
    Route::get('/revisor/dashboard', [RevisorController::class, 'index'])->name('revisor.dashboard');
    Route::post('/revisor/article/{article}/accept', [RevisorController::class, 'accept'])->name('revisor.acceptArticle');
    Route::post('/revisor/article/{article}/reject', [RevisorController::class, 'reject'])->name('revisor.rejectArticle');
});

Route::middleware(['auth', UserIsWriter::class])->group(function () {
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}/update', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

Route::middleware(['auth', UserIsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/assign-role/{user}', [AdminController::class, 'assignRole'])->name('admin.assignRole');
    Route::post('/admin/remove-role/{user}', [AdminController::class, 'removeRole'])->name('admin.removeRole');
    Route::post('/admin/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('/admin/job-applications', [JobApplicationController::class, 'index'])->name('admin.jobApplications');
    Route::post('/admin/job-application/{id}/accept', [JobApplicationController::class, 'accept'])->name('admin.acceptApplication');
    Route::post('/admin/job-application/{id}/reject', [JobApplicationController::class, 'reject'])->name('admin.rejectApplication');
});

Route::middleware(['auth', UserIsOwner::class])->group(function () {
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/job-applications', [OwnerDashboardController::class, 'showApplications'])->name('owner.jobApplications');
    Route::post('/owner/job-applications/{id}/accept', [OwnerDashboardController::class, 'acceptApplication'])->name('owner.acceptJob');
    Route::post('/owner/job-applications/{id}/reject', [OwnerDashboardController::class, 'rejectApplication'])->name('owner.rejectJob');
});
