<?php

namespace Mys\percobaan\MVC\RepositoryUsers;

use Mys\percobaan\MVC\Domains\sessions;


class SessionRepo 
{
    private \PDO $Connects;

    public function __construct($Connects)
    {
        $this->Connects = $Connects;
    }

    public function Save(sessions $sessions_users):sessions{

        $sql = "INSERT INTO sessions(id, User_id) VALUES(?, ?)";
        $Stmt = $this->Connects->prepare($sql);
        $Stmt->execute([$sessions_users->id, $sessions_users->User_id]);
        
        return $sessions_users;


    }

    public function FindID(string $id): ?sessions{

        $sql = "SELECT * FROM sessions WHERE id = ? ";
        $Stmt = $this->Connects->prepare($sql);
        $Stmt->execute([$id]);

        try {
            if($Row = $Stmt->fetch()){
                $sessions_users = new sessions();
                $sessions_users->id = $Row["id"];
                $sessions_users->User_id = $Row["User_id"];
                return $sessions_users;
            }else{
                return null;
            }
        } finally {
            $Stmt->closeCursor();
        }

    }

    public function DeleteID(string $id):void{

        $sql = "DELETE FROM sessions WHERE id = ?";
        $del = $this->Connects->prepare($sql);
        $del->execute([$id]);
        

    }
    
    public function DeleteAll(){

        $sql = "DELETE FROM sessions";
        $this->Connects->exec($sql);
        
    }


}