<?php

namespace Mys\percobaan\MVC\APP;
// use Mys\percobaan\MVC\Controller\HomeController;

Class Router{

    private static array $Routes = [];

    public static function Add(string $Method, string $Path, string $Controller, string $Function, array $Middlewares = []){

        self::$Routes[] = [

            "Method" => $Method,
            "Path" => $Path,
            "Controller" => $Controller, 
            "Function" => $Function,
            "Middleware" => $Middlewares,

        ];

    }

    public static function Run():void{

        $Path ="/";

        if(isset($_SERVER["PATH_INFO"])){
            $Path = $_SERVER["PATH_INFO"];
        }
            $Method = $_SERVER["REQUEST_METHOD"];

        
    foreach(self::$Routes as $Route){
        $Pattern = "#^".$Route["Path"]."$#";
            if(preg_match($Pattern, $Path, $Variables) && $Method == $Route["Method"]){

                $Function = $Route["Function"];
                $Controller = new $Route["Controller"];

                foreach($Route["Middleware"] as $Middleware){
                    $instances = new $Middleware;
                    $instances->Befores();
                }
              
                array_shift($Variables);
                call_user_func_array([$Controller, $Function], $Variables);

                return;
            }
               
            }
            http_response_code(404);
            echo "CONTROLLER FAILED!"; 
        }   
           

    }

