<?php

namespace Mys\percobaan\MVC\Controller;

use Mys\percobaan\MVC\APP\Vie;
use Mys\percobaan\MVC\ServicesUsers\UsersSers;
use Mys\percobaan\MVC\ServicesUsers\SessionSers;
use Mys\percobaan\MVC\Model\UsersRequest;
use Mys\percobaan\MVC\Model\UpdatePasswordRequest;
use Mys\percobaan\MVC\Model\UpdatePasswordResponse;
use Mys\percobaan\MVC\Model\LoginRequest;
use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;

class UsersController
{

    
    private UsersSers $userServices;
    private SessionSers $userSessionSers;
    

    public function __construct()
    {
        $conns = Database::getConnections();
        $reposi = new UsersRepo($conns);
        $this->userServices = new UsersSers($reposi);

        $SessionReposi = new SessionRepo($conns);
        $this->userSessionSers = new SessionSers($SessionReposi, $reposi);

    }

    public function Register()
    {
        Vie::Rendering("Users/Register", [
            "title" => "Register_management"
        ]);
    }

    public function PostRegister()
    {
       $req = new UsersRequest();
       $req->id = $_POST["id"];
       $req->Name_User = $_POST["Name_User"];
       $req->Password = $_POST["Password"];

       

       try {
       $this->userServices->Registers($req);
       Vie::Redirects("/Users/Login");
       } catch (\Exception $ERR) {
        Vie::Rendering("Users/Register", [
            "title" => "Register_management",
            "error" => $ERR->getmessage()
        ]);
       }
    }

    public function Login(){
        Vie::Rendering("Users/Login",[
            "title" => "Login Page"
            
        ]);
    }

    public function PostLogin(){

        $req = new LoginRequest();
        $req->id = $_POST["id"];
        $req->Password = $_POST["Password"];
        
        try {
            $response = $this->userServices->Login($req);
            $this->userSessionSers->Create($response->clientUser->id);
            Vie::Redirects("/");
        } catch (\Exception $ERR) {
            Vie::Rendering("Users/Login", [
                "title"=>"Login_management",
                "error"=>$ERR->getmessage()
                
            ]);
        }
    

    }

    public function Logout(){
        $this->userSessionSers->Destroy();
        Vie::Redirects("/");
    }

    public function UpdatePassword(){

        // $user = $this->userSessionSers->Current();
        Vie::Rendering("Users/UpdatePassword", [
            "title" => "Forgot Password",
        //     "Users" => [
        //         "id" => $user->id
        //     ]
        ]);

    }

    public function PostUpdatePassword(){

        // $this->userSessionSers->Current();
        $users = new UpdatePasswordRequest();
        $users->id = $_POST["id"];
        $users->OldPassword = $_POST["OldPassword"];
        $users->NewPassword = $_POST["NewPassword"];

        $this->userServices->UpdatePassword($users);

        try {
            $this->userServices->UpdatePassword($users);
            Vie::Redirects("/Users/Login");
            } catch (\Exception $e) {
             Vie::Rendering("Users/UpdatePassword", [
                 "title" => "Forgot Password",
                 "error" => $e->getmessage()
                //  "Users" => [
                //     "id" => $user->id
                // ]
             ]);
            }
                
          
        }
    
        
    }

