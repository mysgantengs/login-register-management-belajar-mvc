<?php

namespace Mys\percobaan\MVC\ServicesUsers;

use Mys\percobaan\MVC\Model\UsersResponse;
use Mys\percobaan\MVC\Model\UsersRequest;
use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\Model\LoginRequest;
use Mys\percobaan\MVC\Model\UpdatePasswordRequest;
// use Mys\percobaan\MVC\Model\LoginResponse;
// use Mys\percobaan\MVC\Exceptions\ValidatetionExceptions;
use Mys\percobaan\MVC\Domains\Users;

use PHPUnit\Framework\TestCase;


class UsersSersTest extends TestCase
{
    private UsersSers $userServices;
    private UsersRepo $reposi;
   

    protected function setUp():void
    {
        $conns = Database::getConnections();
        $this->reposi = new UsersRepo($conns);
        $this->userServices = new UsersSers($this->reposi);

        $this->reposi->Delete();
 
    }

    public function testRegisters()
    {
        $req = new UsersRequest();
        $req->id = "tias";
        $req->Name_User = "tiashi";
        $req->Password = "ti7922";
        $respon = $this->userServices->Registers($req);

        self::assertEquals($req->id, $respon->clientUser->id);
        self::assertEquals($req->Name_User, $respon->clientUser->Name_User);
        self::assertNotEquals($req->Password, $respon->clientUser->Password);

        self::assertTrue(password_verify($req->Password, $respon->clientUser->Password));
    }

    public function testRegistersFail(){

        $this->expectException(\Exception::class);

        $req = new UsersRequest();
        $req->id = "";
        $req->Name_User = "";
        $req->Password = "";

        $this->userServices->Registers($req);



    }
    
    public function testRegisterDuplicate(){

        $simple_check = new Users;
        $simple_check->id = "tias";
        $simple_check->Name_User = "tiashi";
        $simple_check->Password = "ti7922";

        $this->reposi->Repo($simple_check);

        $this->expectException(\Exception::class);
        
        $req = new UsersRequest();
        $req->id = "tias";
        $req->Name_User = "tiashi";
        $req->Password = "ti7922";

        $this->userServices->Registers($req);

    }


    public function testLogin(){
        
        $req = new Users();
        $req->id = "tias";
        $req->Name_User = "tiashi";
        $req->Password = password_hash("ti7922",PASSWORD_BCRYPT);

        
        $this->expectException(\Exception::class);

        $req = new LoginRequest();
        $req->id = "tias";
        $req->Password = "ti7922";
        
        $this->userServices->Login($req);

        self::assertEquals($req->id, $respon->clientUser->id);
        self::assertTrue(password_verify($req->Password, $respon->clientUser->Password));
     }

    

    public function testPasswordWrong(){

        $req = new Users();
        $req->id = "tias";
        $req->Name_User = "tiashi";
        $req->Password = password_hash("ti7922",PASSWORD_BCRYPT);

        
        $this->expectException(\Exception::class);

        $req = new LoginRequest();
        $req->id = "tias";
        $req->Password = "ti";
        
        $this->userServices->Login($req);
        
        self::assertEquals($req->id, $respon->clientUser->id);
     }

    public function testLoginFailed(){

        $this->expectException(\Exception::class);

        $req = new LoginRequest();
        $req->id = "tias";
        $req->Password = "tiashi";

        $this->userServices->Login($req);



        
    }


    public function testUpdatePasswordSucces(){


        $Client = new Users();
    
        $Client->id = "ika"; 
        $Client->Name_User = "ika"; 
        $Client->Password = password_hash("ika",PASSWORD_BCRYPT);
        
        $this->reposi->Repo($Client);

        $req = new UpdatePasswordRequest();
        $req->id = "ika";
        $req->OldPassword = "ika";
        $req->NewPassword = "ti";
        
        $this->userServices->UpdatePassword($req);

        $Users =  $this->reposi->FindId($Client->id);

        self::assertTrue(password_verify($req->NewPassword, $Users->Password));

    }

    public function testValidationErrorUpdatePassword(){

        self::expectException(\Exception::class);

        $req = new UpdatePasswordRequest();
        $req->id = "ika";
        $req->OldPassword = "";
        $req->NewPassword = "";
        
        $this->userServices->UpdatePassword($req);

    }

    public function testWrongUpdatePassword(){

        self::expectException(\Exception::class);

        $Client = new Users();
    
        $Client->id = "ika"; 
        $Client->Name_User = "ika"; 
        $Client->Password = password_hash("ika",PASSWORD_BCRYPT);
        
        $this->reposi->Repo($Client);

        $req = new UpdatePasswordRequest();
        $req->id = "ika";
        $req->OldPassword = "apa";
        $req->NewPassword = "ti";
        
        $this->userServices->UpdatePassword($req);

        

    }

    public function testNotFoundUpdatePassword(){

        self::expectException(\Exception::class);

        $req = new UpdatePasswordRequest();
        $req->id = "ika";
        $req->OldPassword = "apa";
        $req->NewPassword = "ti";
        
        $this->userServices->UpdatePassword($req);


    }

}