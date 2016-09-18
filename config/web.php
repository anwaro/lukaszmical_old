<?php 


//$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');



return [
    "url" => "http://lukaszmical.pl/",
    "auth" =>[
        "url" => "admin/login",
        "back" => true,
    ],
    "path" =>[
        "image" => "web/images",
        "proj_image" => "web/images/projects",
        "file" => "web/files",
        
    ],    
    "db" => $db,
];
