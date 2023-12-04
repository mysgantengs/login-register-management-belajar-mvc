<?php

namespace Mys\percobaan\MVC\Controller;
use Mys\percobaan\MVC\APP\Vie;
use Mys\percobaan\MVC\Config\Database;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;
use Mys\percobaan\MVC\ServicesUsers\SessionSers;




class HomeController
{

    private SessionSers $sessionSersUsr;

    public function __construct(){
        $conn = Database::getConnections();
        $reposessns = new SessionRepo($conn);
        $repoUsr = new UsersRepo($conn);
        $this->sessionSersUsr  = new SessionSers($reposessns, $repoUsr);

    }

    public function index(){

        $clientUser = $this->sessionSersUsr->Current();

        if($clientUser == null){

            Vie::Rendering("Home/index", [
                "title"=>"login_management"
            ]);

        }else{

            Vie::Rendering("Home/Dashboards", [
                "title"=>"Dashboards"
            ]);

        }

        
}
}
