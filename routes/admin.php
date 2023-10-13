<?php 

use Tamedevelopers\Route\Route;
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

Route::middleware('admin')->get('admin', function(){


    dump(
        'testing route execution'
    );
})->name('admin.home');


dump(
    'this is the admin.php route file',
    Route::tests()
);