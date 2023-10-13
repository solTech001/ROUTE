<?php

// do not forget we have create a psr4- base name in the composer.json
//  to be `Tamedevelopers\App`
// so in other for this to work, we need to use the Default namespace defined
// and then include path to the folder where we have the class, that wants to inherit the namespace
// with the help of namespace, we do not need to manually load anyclass again into out application

namespace Tamedevelopers\App\Class;

use Tamedevelopers\Request\Request;

class TestClass
{

    
    /**
     * index
     *
     * @param  \Tamedevelopers\Request\Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        dd(
            'texting if route id delivery to other class'
        );
    }

}
