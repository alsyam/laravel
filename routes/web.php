<?php

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;

// use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/al', function () {
    return "Hello Guys ";
});

Route::redirect('/youtube', '/al');

Route::fallback(function () {
    return '404 by al';
});


Route::view('/hello', 'hello', ['name' => 'syam']);

Route::get('/hello-again', function () {
    return view('hello', [
        'name' => 'al'
    ]);
});
Route::get('/hello-world', function () {
    return view('hello.world', [
        'name' => 'alsyam'
    ]);
});


Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
})->name('product.detail');
Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');


Route::get('/users/{id?}', function ($userId = '404') {
    return "User $userId";
})->name('user.detail');

Route::get('conflict/al', function () {
    return "Conflict al syam";
});
Route::get('conflict/{name}', function ($name) {
    return "Conflict $name";
});


Route::get('/product/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('/product-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});


Route::get('/controller/hello/request', [HelloController::class, 'request']);
Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);


Route::get('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello/first', [\App\Http\Controllers\InputController::class, 'helloFirstName']);
Route::post('/input/hello/input', [\App\Http\Controllers\InputController::class, 'helloInput']);
Route::post('/input/hello/array', [\App\Http\Controllers\InputController::class, 'helloArray']);
Route::post('/input/type', [\App\Http\Controllers\InputController::class, 'inputType']);
Route::post('/input/filter/only', [\App\Http\Controllers\InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [\App\Http\Controllers\InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [\App\Http\Controllers\InputController::class, 'filterMerge']);


Route::post('/file/upload', [FileController::class, 'upload'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('response/hello', [ResponseController::class, 'response']);
Route::get('response/header', [ResponseController::class, 'header']);

// response
Route::prefix('/response/type')->group(function () {
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});

Route::controller(CookieController::class)->group(function () {

    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});


Route::get("/redirect/from", [RedirectController::class, "redirectFrom"]);
Route::get("/redirect/to", [RedirectController::class, "redirectTo"]);
Route::get("/redirect/name", [RedirectController::class, "redirectName"]);
Route::get("/redirect/name/{name}", [RedirectController::class, "redirectHello"])->name('redirect-hello');
Route::get("/redirect/named", function () {
    // return route('redirect-hello', ['name' => 'Eko']);
    // return url()->route('redirect-hello', ['name' => 'Eko']);
    return URL::route('redirect-hello', ['name' => 'Eko']);
});


Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);
Route::get('/redirect/away', [RedirectController::class, 'redirectAway']);


// middleware
Route::middleware(['contoh:PZN,401'])->prefix('/middleware')->group(function () {
    Route::get('/api', function () {
        return "OK";
    });
    Route::get('/group', function () {
        return "GROUP";
    });
});

// CSRF
Route::get('/url/action', function () {
    return action([FormController::class, 'form']);
});
Route::get("/form", [FormController::class, 'form']);
Route::post("/form", [FormController::class, 'submitForm']);

// URL GEneretion
Route::get('/url/current', function () {
    return URL::full();
});


// Session
Route::get('/session/create', ([SessionController::class, 'createSession']));
Route::get('/session/get', ([SessionController::class, 'getSession']));

// Error Handling
Route::get('/error/sample', function () {
    throw new Exception("Sample Error");
});
Route::get('/error/manual', function () {
    report(new Exception("Sample Error"));
    return "OK";
});
Route::get('/error/validation', function () {
    throw new \App\Exceptions\ValidationException("Validation Error");
});
