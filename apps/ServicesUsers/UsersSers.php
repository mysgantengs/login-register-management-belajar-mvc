<?php

namespace Mys\percobaan\MVC\ServicesUsers;

use Mys\percobaan\MVC\Model\UsersResponse;
use Mys\percobaan\MVC\Model\UsersRequest;
use Mys\percobaan\MVC\Model\UpdatePasswordRequest;
use Mys\percobaan\MVC\Model\UpdatePasswordResponse;
use Mys\percobaan\MVC\Model\LoginRequest;
use Mys\percobaan\MVC\Model\LoginResponse;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
// use Mys\percobaan\MVC\Exceptions\ValidatetionExceptions;
use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\Domains\Users;


class UsersSers
{
    private UsersRepo $UserRepos;

    public function __construct(UsersRepo $UserRepos){
        $this->UserRepos = $UserRepos;
    }

    public function Registers(UsersRequest $req):UsersResponse
    {
        $this->ValidateUsers($req);

       try {
        Database::beginTransaction();
        $clientUser = $this->UserRepos->FindId($req->id);
        if($clientUser != null){
            throw new \Exception("User already");
        }

        $clientUser = new Users();

        $clientUser->id = $req->id;
        $clientUser->Name_User = $req->Name_User;
        $clientUser->Password =  password_hash($req->Password, PASSWORD_BCRYPT);

        $this->UserRepos->Repo($clientUser);

        $response = new UsersResponse();
        $response->clientUser = $clientUser;
       
        Database::commitTransaction();

        return $response;
       } catch (\Exception $exception) {
        Database::rollbackTransaction();
        throw $exception;
       }
    }

    private function ValidateUsers(UsersRequest $req){
        if($req->id == null ||$req->Name_User == null || $req->Password == null || trim($req->id) == "" || trim($req->Name_User) == "" || trim($req->Password) == ""){
            throw new \Exception("id,name,password blank!");

        }

    }

    public function Login(LoginRequest $req):LoginResponse{
        
        $this->ValidateLogin($req);   

        $clientUser = $this->UserRepos->FindId($req->id);
        if($clientUser == null){
            throw new \Exception("Username/Password is a WRONG!");

        }

        if(password_verify($req->Password, $clientUser->Password)){
           $response = new LoginResponse();
           $response->clientUser = $clientUser;
           return $response;
        }else {
            throw new \Exception("Username/Password is a WRONG!");
        }
    
    }

    public function ValidateLogin(LoginRequest $req){

        if($req->id == null ||  $req->Password == null || trim($req->id) == "" ||  trim($req->Password) == ""){
            throw new \Exception("id,name,password blank!");
        
        
    
        }
}

    public function UpdatePassword(UpdatePasswordRequest $req):UpdatePasswordResponse{

        $this->ValidateUpdatePassword($req);

        try {

            Database::beginTransaction();

            $Users = $this->UserRepos->FindId($req->id);
            if($Users == null){
                throw new \Exception("User is NOT found!");
            }

            if(password_verify($req->OldPassword, $Users->Password)){
                throw new \Exception("Old Password is WRONG");
                
            }

            $Users->Password = password_hash($req->NewPassword, PASSWORD_BCRYPT);
            $Users = $this->UserRepos->Update($Users);

            Database::commitTransaction();

            $response = new UpdatePasswordResponse();
            $response->Users = $Users;
            return $response;



        } catch (\Exception $err) {
            throw $err;
            Database::rollbackTransaction();
            
        }

    }

    public function ValidateUpdatePassword(UpdatePasswordRequest $req){

        if($req->id == null || $req->OldPassword == null || $req->NewPassword == null || trim($req->id) == "" ||  trim($req->OldPassword) == "" ||  trim($req->NewPassword) == ""){
            throw new \Exception("password Not Configures!");
        
        }


    }
}
