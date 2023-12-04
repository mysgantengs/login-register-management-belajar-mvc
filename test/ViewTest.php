<?php

namespace Mys\percobaan\MVC\APP;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testView(){
        Vie::Rendering("Home/index", [
            "Welcome to my World me"
        ]);

        // self::expectOutputRegex("[Welcome to my World me]");
        self::expectOutputRegex("[html]");
        self::expectOutputRegex("[body]");
        self::expectOutputRegex("[Login]");
        self::expectOutputRegex("[Register]");
    }
}

