<?php

namespace Mys\percobaan\MVC\Config;

use PHPUnit\Framework\TestCase;

final class DBtest extends TestCase
{
    public function testgetConnections(){
        
        $Configures = Database::getConnections();

        self::assertNotNull($Configures);

    }

    public function testgetConnectionsSingleton(){

        $Configures1 = Database::getConnections();
        $Configures2 = Database::getConnections();

        self::assertSame($Configures1, $Configures2);
    
    }
}

