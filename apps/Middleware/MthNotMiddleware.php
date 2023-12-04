<?php

namespace Mys\percobaan\MVC\Middleware;

use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\ServicesUsers\SessionSers;
use Mys\percobaan\MVC\APP\Vie;


class MthNotMiddleware implements Middleware
{

    private SessionSers $UserServicesSess;

    public function __construct(){

      $session_userRepo = new SessionRepo(Database::getConnections());
      $userReps = new UsersRepo(Database::getConnections());
        $this->UserServicesSess = new SessionSers($session_userRepo, $userReps);

    }

    function Befores(){

        $clientUser = $this->UserServicesSess->Current();

        if($clientUser != null){
            Vie::Redirects("/");
        }



    }
}