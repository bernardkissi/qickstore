<?php


use App\Domains\Categories\Models\Category;
use App\Domains\Categories\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function () {
    return CategoryResource::collection(Category::with('subcategories', 'subcategories.children')
    ->ordered()
    ->get());
});
