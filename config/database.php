<?php

function GetConnect(){


    return [

        "Databases" => [

            "test" => [

                "url" => "mysql:host=localhost:3306;dbname=login_management_test",
                "Username" => "root",
                "Password" => ""

            ],

            "prod" => [

                "url" => "mysql:host=localhost:3306;dbname=login_management",
                "Username" => "root",
                "Password" => ""

            ]

        ]



            ];

}