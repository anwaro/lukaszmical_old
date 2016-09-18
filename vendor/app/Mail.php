<?php

/*
 * 
 */

class Mail {

    
    public function send($title, $message, $to) {

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Dodatkowe nagłówki
        $headers .= 'From: <admin@hajs.esy.es>' . "\r\n";
        $headers .= 'Reply-To: admin@hajs.esy.es/' . "\r\n" ;
        $headers .= 'X-Mailer: PHP/' . phpversion();
        
        mail($to, $title, $message, $headers);
    }

}


