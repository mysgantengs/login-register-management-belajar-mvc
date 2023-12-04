<?php



namespace Mys\percobaan\MVC\ServicesUsers {
    
    function setcookie(string $name, string $value){
        echo "$name: $value";
    }
}
namespace Mys\percobaan\MVC\Controller{

use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;
use Mys\percobaan\MVC\ServicesUsers\UsersSers;
use Mys\percobaan\MVC\ServicesUsers\SessionSers;
use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\Domains\Users;
use PHPUnit\Framework\TestCase;

class ViewsTest extends TestCase
{
    private UsersController $usersConns;
    private UsersRepo $reppsUser;
    private SessionRepo $sessionRepos;

    protected function setUp():void
    {

        $this->usersConns = new UsersController();
        $this->sessionRepos = new SessionRepo(Database::getConnections());

        $this->RepoUser = new UsersRepo(Database::getConnections());
        $this->RepoUser->Delete();
        // $this->usersConns new UsersController();
    }

    public function testRegister()
    {
        $this->usersConns->Register();
        self::expectOutputRegex("[Register]");
        self::expectOutputRegex("[id]");
        self::expectOutputRegex("[Name User]");
        self::expectOutputRegex("[Password]");       
        self::expectOutputRegex("[Register_management]");       
    }   

    public function testPostRegister()
    {
        $this->usersConns->Register();

        $_POST["id"] = "aeki";
        $_POST["Name_User"] = "aeki";
        $_POST["Password"] = "aeki";

        self::expectOutputRegex("[Register]");
        self::expectOutputRegex("[id]");
        self::expectOutputRegex("[Name User]");
        self::expectOutputRegex("[Password]");       
        self::expectOutputRegex("[Register_management]");    


    }

    public function testLogin()
    {
        $userLogin = new Users();
        $userLogin->id = "aeki";
        $userLogin->Name_User = "aeki";
        $userLogin->Password = password_hash("aeki", PASSWORD_BCRYPT);

        $this->RepoUser->Repo($userLogin);

        $_POST["id"] = "aeki"; 
        $_POST["Password"] = "aeki";

        $this->usersConns->PostLogin();

        self::expectOutputRegex("[Location: /]");



    }


    public function testLogout(){

        $userLogin = new Users();
        $userLogin->id = "aeki";
        $userLogin->Name_User = "aeki";
        $userLogin->Password = password_hash("aeki", PASSWORD_BCRYPT);

        $this->RepoUser->Repo($userLogin);

        $usersessions = new sessions();
        $usersessions->id = uniqid();
        $usersessions->User_id = $usersessions->id;

        $this->sessionRepos->Save($usersessions);

        $_COOKIE[SessionSers::$COOKIE_Name] = $usersession->id;

        $this->usersConns->Logout();

        $self::expectOutputRegex("[Location: /]");
        $self::expectOutputRegex("[SersCOOKIE: ]");

    }


    public function testUpdate(){


     $users = new UpdatePasswordRequest();
     $users->id = "ika";
     $users->OldPassword = "ika";
     $users->NewPassword = "udin";

     $this->RepoUser->Repo($users);

     $_POST["id"];
     $_POST["OldPassword"];
     $_POST["NewPassword"];

     
     $this->RepoUser->Update($users);

     self::expectOutputRegex("[Old Password is WRONG]");
     self::expectOutputRegex("[Forgot You Password]");
     self::expectOutputRegex("[Id]");
     self::expectOutputRegex("[Input my Old Password]");
     self::expectOutputRegex("[Input my New Password]");
     self::expectOutputRegex("[Update]");
     

    }

    public function testFailedUpdate(){

        $users = new UpdatePasswordRequest();
        $users->id = "ika";
        $users->OldPassword = "ika";
        $users->NewPassword = "";
   
       
   
        $UsP = $_POST["id"];
        $UsP = $_POST["OldPassword"];
        $UsP = $_POST["NewPassword"];

        $this->RepoUser->Update($UsP);

        self::expectOutputRegex("[Forgot You Password]");
        self::expectOutputRegex("[Id]");
        self::expectOutputRegex("[Input my Old Password]");
        self::expectOutputRegex("[Input my New Password]");
        self::expectOutputRegex("[Update]");
        
    }
}

}
