<?php

namespace Mys\percobaan\MVC\ServicesUsers;
use Mys\percobaan\MVC\Domains\sessions;
use Mys\percobaan\MVC\Domains\Users;
use Mys\percobaan\MVC\RepositoryUsers\SessionRepo;
use Mys\percobaan\MVC\RepositoryUsers\UsersRepo;

class SessionSers
{

  public static string $COOKIE_Name = "SersCOOKIE"; 
  
  private SessionRepo $reps_user;
  private UsersRepo $repositorys;

   public function __construct($reps_user, $repositorys){

    $this->reps_user = $reps_user;
    $this->repositorys = $repositorys;
    
   } 

  public function Create(string $User_id):sessions{

    $session = new sessions();
    $session->id = uniqid();
    $session->User_id = $User_id;

    $this->reps_user->Save($session);

    setcookie(self::$COOKIE_Name, $session->id, time()+(60+60+24+30), "/");

    return $session;

  }

  public function Destroy(){

    $session_id = $_COOKIE[self::$COOKIE_Name] ?? " ";
    $this->reps_user->DeleteID($session_id);

    setcookie(self::$COOKIE_Name, '', 1, "/");

    }

  public function Current():?Users{
    $session_Id = $_COOKIE[self::$COOKIE_Name] ?? "";

    $session = $this->reps_user->FindID($session_Id);

    if($session == null){
        return null;
    }

    $users = $this->repositorys->FindID($session->User_id);
    return $users;
  }

}