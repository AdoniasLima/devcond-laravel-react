<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FoundAndLostController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;

Route::get("/ping", function(){
    return json_encode(["pong" => true]);
});

Route::get("/401", [AuthController::class, "unauthorized"])->name("login");
Route::post("/auth/login", [AuthController::class, "login"]);
Route::post("/auth/register", [AuthController::class, "register"]);
Route::middleware("auth:api")->group(function(){
    Route::post("/auth/validate", [AuthController::class, "validateToken"]);
    Route::post("/auth/logout", [AuthController::class, "logout"]);
    //Walls
    Route::get("/walls", [WallController::class, "getAll"]);
    Route::post("/wall/{id}/like", [WallController::class, "like"]);
    //Docs
    Route::get("/docs", [DocController::class, "getAll"]);
    //Warnings
    Route::get("/warnings", [WarningController::class, "getMyWarnings"]);
    Route::post("/warning", [WarningController::class, "setWarning"]);
    Route::post("/warning/file", [WarningController::class, "addWarningFile"]);
    //Billets
    Route::get("/billets", [BilletController::class, "getAll"]);
    //Found and lost
    Route::get("/foundandlost", [FoundAndLostController::class, "getAll"]);
    Route::post("/foundandlost", [FoundAndLostController::class, "insert"]);
    Route::put("/foundandlost/{id}", [FoundAndLostController::class, "update"]);
    //Units
    Route::get("/unit/{id}", [FoundAndLostController::class, "getInfo"]);
    Route::post("/unit/{id}/addperson", [UnitController::class, "addPerson"]);
    Route::post("/unit/{id}/addvehicle", [UnitController::class, "addVehicle"]);
    Route::post("/unit/{id}/addpet", [UnitController::class, "addPet"]);
    Route::delete("/unit/{id}/removeperson", [UnitController::class, "removePerson"]);
    Route::delete("/unit/{id}/removevehicle", [UnitController::class, "removeVehicle"]);
    Route::delete("/unit/{id}/removepet", [UnitController::class, "removePet"]);
    //Reservations
    Route::get("/reservations", [ReservationController::class, "getReservations"]);
    Route::post("/reservation/{id}", [ReservationController::class, "setReservation"]);
    Route::get("/reservation/{id}/disableddates", [ReservationController::class, "getDisabledDates"]);
    Route::get("/reservation/{id}/times", [ReservationController::class, "getTimes"]);
    Route::get("/myreservations", [ReservationController::class, "getMyReservations"]);
    Route::delete("/myreservation/{id}", [ReservationController::class, "removeReservation"]);
});