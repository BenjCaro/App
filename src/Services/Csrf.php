<?php 

namespace Carbe\App\Services;

class Csrf {

    public static function get() :string {
        
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function check($token, $view) {

          if(empty($token) || $_SESSION['csrf_token'] !== $token) {
          Flash::set("Erreur survenue.", "secondary");
          header("Location: .$view");
          exit;
     }
    }

}