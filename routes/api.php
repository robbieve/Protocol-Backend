<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return [
        'error_code'    => 0,
        'data'          => $request->user()
    ];
});

$resourcesRequireAuthToWrite = [
    'relations'         => 'API\RelationController',
    'elements'          => 'API\ElementController',
    'bridges'           => 'API\BridgeController',
    'notes'             => 'API\NoteController',
    'userFollow'        => 'API\UserFollowController',
    'elementFollow'     => 'API\ElementFollowController',
    'noteCategory'      => 'API\NoteCategoryController',
    'contentReport'      => 'API\ContentReportController',
];

$withAuthRouteOptions = [
    'only'          => ['store', 'update', 'destroy','index'],
    'middleware'    => ['auth:api'],
];

$withoutAuthRouteOptions = [
    'only'          => [ 'show']
];

foreach ($resourcesRequireAuthToWrite as $name => $controller) {
    Route::apiResource($name, $controller, $withAuthRouteOptions);
    Route::apiResource($name, $controller, $withoutAuthRouteOptions);
}
Route::post('/elementData', 'API\ElementController@elementData')->middleware('auth:api');
Route::post('/contentLike', 'API\UserFollowController@contentLike')->middleware('auth:api');
Route::post('/register', 'API\UserController@register');
// Route::post('/login', 'API\UserController@login')->middleware(['web']);
Route::get('/login', 'API\UserController@login')->middleware('auth:api');
Route::post('/search/page', 'API\PageController@search');
Route::delete('/deleteElement/{id}', 'API\ElementController@deleteElement');
Route::post('/search/pages', 'API\PageController@batchSearch');

Route::group(['middleware' => ['web']], function () {
    Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->where([ 'provider' => 'facebook|google' ]);
    Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where([ 'provider' => 'facebook|google' ]);
});
