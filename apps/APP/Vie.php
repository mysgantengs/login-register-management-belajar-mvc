<?php

namespace Mys\percobaan\MVC\APP;

class Vie{
    
    public static function Rendering($view, $Model){
        require __DIR__. "/../view/Header.php";
        require __DIR__. "/../view/".$view.".php";   
        require __DIR__. "/../view/Footer.php";     
    
    }

    public static function Redirects(string $Url){
        header("Location: $Url");
        exit();
    }
}