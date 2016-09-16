<?php 


//$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');



return [
    "url" => "http://lukaszmical.pl/",
    "path" =>[
        "image" => "public/images",
        "proj_image" => "public/images/projects",
        "file" => "public/files",
        
    ],

    
    "db" => $db,
];
