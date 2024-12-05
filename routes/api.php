<?php

use App\Http\Controllers\Api\Admin\AdsController;
use App\Http\Controllers\Api\Admin\DeveloperControlelr;
use App\Http\Controllers\Api\Admin\HomepageController;
use App\Http\Controllers\Api\Admin\UnitController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);



Route::middleware(['auth:sanctum', 'IsAdmin'])->group(function () {

    Route::get('/admin/homepage',[HomepageController::class, 'homepage']);

    Route::post('/admin/logout',[AuthController::class, 'logout']);

    /////////////////////////////////// ADS ////////////////////////////////////////////////////

    Route::get('/admin/ads',[AdsController::class, 'getAds']);

    Route::post('/admin/ads/add',[AdsController::class, 'addAdds']);

    Route::delete('/admin/ads/delete/{id}',[AdsController::class, 'deleteAds']);

//////////////////////////////////// Users ////////////////////////////////////////////////////

    Route::get('/admin/users',[UserController::class, 'getUsers']);

    Route::delete('/admin/users/delete/{id}',[UserController::class, 'deleteuser']);

    Route::get('/admin/admins',[UserController::class, 'getAdmins']);

    Route::post('/admin/admins/add',[UserController::class, 'addAdmin']);

    Route::delete('/admin/admins/delete/{id}',[UserController::class, 'deleteadmin']);

///////////////////////////////////////////// Developer ///////////////////////////////////////

    Route::get('/admin/developers',[DeveloperControlelr::class, 'AllDevelopers']);

    Route::get('/admin/developer/{id}',[DeveloperControlelr::class, 'developer']);

    Route::post('/admin/developer/add',[DeveloperControlelr::class, 'addDeveloper']);

    Route::delete('/admin/developer/delete/{id}',[DeveloperControlelr::class, 'deleteDeveloper']);

    Route::put('/admin/developer/update/{id}',[DeveloperControlelr::class, 'updateDeveloper']);

//////////////////////////////////////////// Uptowns (units) ////////////////////////////////////////////////

    Route::get('/admin/units/{developer_id}',[UnitController::class, 'unitDeveloper']);


});
