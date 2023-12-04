<?php

namespace Mys\percobaan\MVC\ServicesUsers;

use Mys\percobaan\MVC\Domains\sessions;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;
use PHPUnit\Framework\TestCase;

function setcookie(string $name, string $value)
{
    echo "$name: $value";
}

class SessionSersTest extends TestCase
{
    private SessionSers $session_usersSers;
    private SessionRepo $session_usersRepo;
    private UsersRepo $userRepo;

    protected function setUp():void{

        $this->session_usersRepo = new SessionRepo(Database::getConnections());
        $this->userRepo = new UsersRepo(Database::getConnections());
        $this->session_usersSers = new SessionSers($this->session_usersRepo, $this->userRepo);

        $this->session_usersRepo->DeleteAll();
        $this->userRepo->Delete();

    }

    public function testCreate(){
        
        $Sessions = $this->session_usersSers->Create("ika");

        self::expectOutputRegex("[SersCOOKIE: $Sessions->id]");

       
        $rslt = $this->session_usersRepo->FindID($Sessions->id);

        self::assertEquals("ika", $rslt->User_id);
        
    }

    public function testDestroy(){

        $UsersSession = new sessions();
        $UsersSession->id = uniqid();
        $UsersSession->User_id = "ika";


        $this->session_usersRepo->Save($UsersSession);

        $_COOKIE[SessionSers::$COOKIE_Name] = $UsersSession->id;

        $this->session_usersSers->Destroy();

        self::expectOutputRegex("[SersCOOKIE: ]");

        $results = $this->session_usersRepo->FindID($UsersSession->id);
        self::assertNull($results);


    }

    public function testCurrent(){

        $UsersSession = new sessions();
        $UsersSession->id = uniqid();
        $UsersSession->User_id = "nina";


        $this->session_usersRepo->Save($UsersSession);

        $_COOKIE[SessionSers::$COOKIE_Name] = $UsersSession->id;

        $Usr = $this->session_usersSers->Current();

        self::assertEquals($UsersSession->User_id, $Usr->id);

    }
}
