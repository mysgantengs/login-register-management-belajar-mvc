<?php


namespace Mys\percobaan\MVC\RepositoryUsers;

use PHPUnit\Framework\TestCase;

use Mys\percobaan\MVC\RepositoryUsers;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\ServicesUsers\SessionSers;
use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\Domains\Users;
use Mys\percobaan\MVC\Domains\sessions;

use Mys\percobaan\MVC\Controller\HomeController;

final class HomeControllerTest extends TestCase
{
    private HomeController $userHomeController; 
    private SessionRepo $userSessionRepos; 
    private UsersRepo $userRepos;
    
    protected function setUp():void{
        $this->userHomeController = new HomeController();
        $this->userSessionRepos = new SessionRepo(Database::getConnections());
        $this->userRepos = new UsersRepo(Database::getConnections());

        $this->userSessionRepos->DeleteAll();
        $this->userRepos->Delete();
    }

    public function testGuestLogin(){

        $this->userHomeController->index();
        self::expectOutputRegex("[login_management]");

    }

    public function testGuestPostLogin(){

        $Users = new Users();
        $Users->id = "ika";
        $Users->Name_User = "ika";
        $Users->Password = "ika";

        $this->userRepos->Repo($Users);

        $session = new sessions();
        $session->id = uniqid();
        $session->User_id = $Users->id;

        $this->userSessionRepos->Save($session);

        $_COOKIE[SessionSers::$COOKIE_Name] = $session->id;



        $this->userHomeController->index();
        self::expectOutputRegex("[Navbar]");
        
    }


    public function testUpdate(){

        

    }
    
}
