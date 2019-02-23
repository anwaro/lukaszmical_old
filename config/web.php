<?php 

$db = require(__DIR__ . '/db.php');

return [
    "auth" =>[
        "url" => "admin/login",
        "back" => true,
    ],
    "path" =>[
        "image" => "images",
        "proj_image" => "images/projects",
        "file" => "files",
        
    ],    
    "db" => $db,
];
