<?php

namespace Mys\percobaan\MVC\APP{
    function header(string $value){
        echo $value;
    }
}

namespace Mys\percobaan\MVC\Middleware{

use PHPUnit\Framework\TestCase;
use Mys\percobaan\MVC\Domains\Users;
use Mys\percobaan\MVC\Domains\sessions;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\ServicesUsers\SessionSers;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;
use Mys\percobaan\MVC\Config\Database;

class MiddlewareTest extends TestCase
{
    private MthMiddleware $Middle;
    private UsersRepo $repoUser;
    private SessionRepo $sessionUser;
    

    protected function setUp():void{
        
        $this->Middle = new MthMiddleware();
        // $this->repoUser = new UsersRepo();

        putenv("mode=test");

         $this->sessionUser = new SessionRepo(Database::getConnections()); 
         $this->repoUser = new UsersRepo(Database::getConnections()); 

         $this->repoUser->Delete();
         $this->sessionUser->DeleteAll();
    }

    public function testBefores(){
        
        $this->Middle->Befores();

        $this->expectOutputRegex("[Location: /Users/Login]");

    }

    public function testUserBefores(){

        $user = new Users();
        $user->id = "ika";
        $user->Name_User = "ika";
        $user->Password = "ika";

        $sessions = new sessions();
        $sessions->id = "ika";
        $sessions->User_id = "ika";
        

        $this->repoUser->Repo($user);

        $_COOKIE[SessionSers::$COOKIE_Name] = $user->id;

        $this->Middle->Befores();

        $this->expectOutputString("");

    }
}

}