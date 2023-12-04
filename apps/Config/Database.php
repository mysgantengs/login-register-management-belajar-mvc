<?php

namespace Mys\percobaan\MVC\Config;

class Database{


    private static ?\PDO $pdo = null;

    public static function getConnections($env = "test"):\PDO{
        if (self::$pdo == null) {

            require __DIR__. "/../../config/database.php";
            
            $Configure = GetConnect();
            self::$pdo = new \PDO (

                $Configure["Databases"][$env]["url"],
                $Configure["Databases"][$env]["Username"],
                $Configure["Databases"][$env]["Password"]



            );
          }
        return self::$pdo;
    }

    public static function beginTransaction()
    {
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction()
    {
        self::$pdo->commit();
    }

    public static function rollbackTransaction()
    {
        self::$pdo->rollback();
    }

    
    

}