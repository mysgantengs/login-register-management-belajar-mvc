<?php

namespace Mys\percobaan\MVC\RepositoryUsers;



use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\Domains\Users;

use PHPUnit\Framework\TestCase;



class RepoTest extends TestCase{

    private UsersRepo $repositors;

    protected function setUp():void{

        $this->repositors = new UsersRepo(Database::getConnections());
        $this->repositors->Delete();

    }

    public function testRepoSaving(){

        $Client = new Users();
    
        $Client->id = "ikang"; 
        $Client->Name_User = "nganjuk"; 
        $Client->Password = "cresis3245";
        
        $this->repositors->Repo($Client);
        $Resul = $this->repositors->FindId($Client->id);

        self::assertEquals($Client->id, $Resul->id);
        self::assertEquals($Client->Name_User, $Resul->Name_User);
        self::assertEquals($Client->Password, $Resul->Password);

    }

    public function testFindIdnotfound(){
        
        $Users = $this->repositors->FindId("not found");
        self::assertNull($Users);
    }

}