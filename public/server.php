<?php 

    if (file_exists('../app/user.php')) {
        require_once '../app/user.php';
    } else {
        file_get_contents("Error file user not found");
        http_response_code(404);
        exit;        
    }
