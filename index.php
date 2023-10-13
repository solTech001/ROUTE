<?php 

use Tamedevelopers\Support\Env;
use Tamedevelopers\Support\Capsule\DebugManager;

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

require __DIR__.'/vendor/autoload.php';


// This is just a helper to create error logger
// and error handler
DebugManager::boot();
// Env::bootLogger();



// manually adding the web route for testing purpose only
// later on we'll device a way to autoload and register all routes from a particular phase
// so our app can be a little similar to that of Laravel
// the only folder you should concentrate on working on is the `src folder` where our Library code stays

// at the end of the day we can create a method that will auto generate every other relevant files 
// into our application. for now just work and test locally
require base_path('routes/web.php');
require base_path('routes/admin.php');