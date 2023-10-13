<?php 

use Tamedevelopers\Route\Route;
use Tamedevelopers\Request\Request;
use Tamedevelopers\Route\RouteHelper;
use Tamedevelopers\App\Class\TestClass;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/


// Route::middleware('web')
//     ->group(base_path('routes/web.php'));

Route::middleware('web')
    ->get('/{shortner?}', [Route::class, ''])
    ->name('web.home');



// products group
Route::group(['prefix' => 'store'], function(){
    Route::get('/{slug?}', [TestClass::class, 'index'])->name('products.home');
    Route::post('addToCart', [TestClass::class, 'addToCart'])->name('products.addToCart');
    Route::post('updateCart', [TestClass::class, 'updateCart'])->name('products.updateCart');
    Route::post('removeFromCart', [TestClass::class, 'removeFromCart'])->name('products.removeFromCart');
    Route::post('recommend', [TestClass::class, 'recommend'])->name('products.recommend');
    Route::post('preview', [TestClass::class, 'preview'])->name('products.preview');
});


Route::dispatch(
    $_SERVER['REQUEST_METHOD'], 
    $_SERVER['REQUEST_URI']
);

dump(
    'testing .htaccess',
    Route::request(),
    Route::request()->getUrl(),
    // Route::tests(),
    // RouteHelper::generateUrl(),
);
