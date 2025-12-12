<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\FormationController as AdminFormationController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');
Route::get('/guide-gratuit', [HomeController::class, 'guideGratuit'])->name('guide-gratuit');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/article/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');
Route::get('/formations/{slug}', [FormationController::class, 'show'])->name('formations.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::post('/article/{article}/comment', [CommentController::class, 'store'])->name('comments.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('articles', AdminArticleController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('formations', AdminFormationController::class)->except(['show']);
    
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    
    Route::get('/newsletters', [AdminNewsletterController::class, 'index'])->name('newsletters.index');
    Route::delete('/newsletters/{newsletter}', [AdminNewsletterController::class, 'destroy'])->name('newsletters.destroy');
    
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});
