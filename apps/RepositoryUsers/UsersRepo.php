<?php

namespace Mys\percobaan\MVC\RepositoryUsers;

use Mys\percobaan\MVC\Domains\Users;

class UsersRepo{

    private \PDO $Connecting;

    public function __construct($Connecting){

        $this->Connecting = $Connecting;
    }

    

    public function Repo(Users $Saving):Users{
        $sql = "INSERT INTO users(id, Name_User, Password) VALUES(?, ?, ?)";
        $repouser = $this->Connecting->prepare($sql);
        $repouser->execute([$Saving->id, $Saving->Name_User, $Saving->Password]);

        return $Saving;

    }


    public function FindId(string $id):?Users{

        $sql = "SELECT * FROM users WHERE id = ?";
        $innecs = $this->Connecting->prepare($sql);
        $innecs->execute([$id]);

        try {
            if($Row = $innecs->fetch()){

                $Saving = new Users();
    
                $Saving->id = $Row["id"]; 
                $Saving->Name_User = $Row["Name_User"]; 
                $Saving->Password = $Row["Password"]; 
                return $Saving;
        }else{
            return null;
        }     
        } finally {
            $innecs->closeCursor();
        }

       }


       public function Update(Users $Users){

            $sql = "UPDATE users SET Password = ? WHERE id = ? ";
            $res = $this->Connecting->prepare($sql);
            $res->execute([$Users->Password, $Users->id]);
            return $Users;

       }

        public function Delete(){
            $sql = "DELETE FROM users";
            $this->Connecting->exec($sql);
            
        }



    }

    

