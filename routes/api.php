<?php

use App\Http\Controllers\Api\SearchController;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/search', [SearchController::class, 'search']);
Route::get('/search/logs', [SearchController::class, 'logs']);
Route::get('/test-indexing', function () {
    $blog = Blog::create([
        'title' => 'Hello World',
        'body' => 'This is a blog post created for indexing test.',
    ]);

    sleep(2); // give queue time to run if using queue

    $blog->update([
        'title' => 'Updated Title for Meilisearch',
    ]);

    sleep(2);

  //  $blog->delete();

    return 'Created, updated, and deleted a blog with Scout indexing.';
});