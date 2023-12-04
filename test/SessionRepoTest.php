<?php

namespace Mys\percobaan\MVC\RepositoryUsers;



use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\Domains\sessions;
use Mys\percobaan\MVC\Domains\Users;
use PHPUnit\Framework\TestCase;



class SessionRepoTest extends TestCase{

    private SessionRepo $RepoSession;
    private UsersRepo $RepoUser;

    protected function setUp():void{

        $this->RepoUser = new UsersRepo(Database::getConnections());

        $this->RepoSession = new SessionRepo(Database::getConnections());
        $this->RepoSession->DeleteAll();
        $this->RepoUser->Delete();

        $user = new Users();
        $user->id = "ina";
        $user->Name_User = "ina";
        $user->Password = "ina";

        $this->RepoUser->Repo($user);

    }

    public function testSession(){

        $sessions_users = new sessions();
        $sessions_users->id = uniqid();
        $sessions_users->User_id = "ikong";

        $this->RepoSession->Save($sessions_users);

        $results = $this->RepoSession->FindID($sessions_users->id);

        self::assertEquals($sessions_users->id, $results->id);
        self::assertEquals($sessions_users->User_id, $results->User_id);





    }


    public function testDeleteSession(){

        $sessions_users = new sessions();
        $sessions_users->id = uniqid();
        $sessions_users->User_id = "ikong";

        $this->RepoSession->Save($sessions_users);

        $results = $this->RepoSession->FindID($sessions_users->id);

        self::assertEquals($sessions_users->id, $results->id);
        self::assertEquals($sessions_users->User_id, $results->User_id);

        $this->RepoSession->DeleteID($sessions_users->id);

        $result = $this->RepoSession->FindID($sessions_users->id);

        self::assertNull($result);

    }

    public function testSessionNotFound(){
        
        $result = $this->RepoSession->FindID("not FOUND!");
        
        self::assertNull($result);
    
    }

}