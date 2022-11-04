<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use RichardPK\Search\Controllers\SearchController;

Route::middleware('web')->get('/search', [SearchController::class, 'get'])
           ->name('search.get');