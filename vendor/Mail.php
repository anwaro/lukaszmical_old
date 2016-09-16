<?php

/*
 * 
 */

class Mail {
    
    private $userInfo;
    
    
    public function confirm($user) {
        $this->userInfo = $user;
        $message = preg_replace_callback('/{%([^%]+)%}/', 'self::getInfo', implode('', file('views/mailTemplate.php')));
        $this->send("Potwierdzenie konta na portalu `hajs sie zgadza`", $message, $this->userInfo["mail"]);
    }
    
    public function getInfo($name) {
        return $this->userInfo[$name[1]];
    }
    
    public function send($title, $message, $to) {

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Dodatkowe nagłówki
        $headers .= 'From: Administrator Strony <admin@hajs.esy.es>' . "\r\n";
        $headers .= 'Reply-To: admin@hajs.esy.es/' . "\r\n" ;
        $headers .= 'X-Mailer: PHP/' . phpversion();
        /*
        echo "to $to <br>".
                "titlt $title <br>".
                "messsage $message <br>".
                "headers $headers <br>";
         * 
         */
         
        mail($to, $title, $message, $headers);
    }

}


