<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/goals',[GoalController::class,'index'])->name('goals.index');
Route::post('/goals/set',[GoalController::class,'setGoal'])->name('goals.set');

Route::get('/goals/{id}/distribute',[GoalController::class,'distribute'])->name('goals.distribute');
Route::post('/goals/{id}/distribute/save',[GoalController::class,'saveDistribution'])->name('goals.distribute.save');


