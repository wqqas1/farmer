<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\IncomeTagsController;
use App\Http\Controllers\ExpenseTagsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
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

// Auth

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('remember', 'auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('remember', 'auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('remember', 'auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Goals

Route::get('goals', [GoalsController::class, 'index'])
    ->name('goals')
    ->middleware('remember', 'auth');

Route::get('goals/create', [GoalsController::class, 'create'])
    ->name('goals.create')
    ->middleware('auth');

Route::post('goals', [GoalsController::class, 'store'])
    ->name('goals.store')
    ->middleware('auth');

Route::get('goals/{goal}/edit', [GoalsController::class, 'edit'])
    ->name('goals.edit')
    ->middleware('auth');

Route::put('goals/{goal}', [GoalsController::class, 'update'])
    ->name('goals.update')
    ->middleware('auth');

Route::delete('goals/{goal}', [GoalsController::class, 'destroy'])
    ->name('goals.destroy')
    ->middleware('auth');

Route::put('goals/{goal}/restore', [GoalsController::class, 'restore'])
    ->name('goals.restore')
    ->middleware('auth');

// Income Tags

Route::get('income_tags', [IncomeTagsController::class, 'index'])
    ->name('income_tags')
    ->middleware('remember', 'auth');

Route::get('income_tags/create', [IncomeTagsController::class, 'create'])
    ->name('income_tags.create')
    ->middleware('auth');

Route::post('income_tags', [IncomeTagsController::class, 'store'])
    ->name('income_tags.store')
    ->middleware('auth');

Route::get('income_tags/{income_tag}/edit', [IncomeTagsController::class, 'edit'])
    ->name('income_tags.edit')
    ->middleware('auth');

Route::put('income_tags/{income_tag}', [IncomeTagsController::class, 'update'])
    ->name('income_tags.update')
    ->middleware('auth');

Route::delete('income_tags/{income_tag}', [IncomeTagsController::class, 'destroy'])
    ->name('income_tags.destroy')
    ->middleware('auth');

Route::put('income_tags/{income_tag}/restore', [IncomeTagsController::class, 'restore'])
    ->name('income_tags.restore')
    ->middleware('auth');

// Expense Tags
Route::get('expense_tags', [ExpenseTagsController::class, 'index'])
    ->name('expense_tags')
    ->middleware('remember', 'auth');

Route::get('expense_tags/create', [ExpenseTagsController::class, 'create'])
    ->name('expense_tags.create')
    ->middleware('auth');

Route::post('expense_tags', [ExpenseTagsController::class, 'store'])
    ->name('expense_tags.store')
    ->middleware('auth');

Route::get('expense_tags/{expense_tag}/edit', [ExpenseTagsController::class, 'edit'])
    ->name('expense_tags.edit')
    ->middleware('auth');

Route::put('expense_tags/{expense_tag}', [ExpenseTagsController::class, 'update'])
    ->name('expense_tags.update')
    ->middleware('auth');

Route::delete('expense_tags/{expense_tag}', [ExpenseTagsController::class, 'destroy'])
    ->name('expense_tags.destroy')
    ->middleware('auth');

Route::put('expense_tags/{expense_tag}/restore', [ExpenseTagsController::class, 'restore'])
    ->name('expense_tags.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
