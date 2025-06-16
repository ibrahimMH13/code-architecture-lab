<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return "ibrahim";
});


Route::resource('/notes', NoteController::class);
