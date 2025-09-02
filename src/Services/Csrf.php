<?php 

namespace Carbe\App\Services;

class Csrf {

    public static function get($formName) {
       
       
        if (!isset($_SESSION['csrf_tokens']) || !is_array($_SESSION['csrf_tokens'])) {
            $_SESSION['csrf_tokens'] = []; 
        }

        if(!isset($_SESSION['csrf_tokens'][$formName])) {
            $_SESSION['csrf_tokens'][$formName] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_tokens'][$formName];
    }

    public static function check($formName, $token, $view) {

          if(empty($token) || $_SESSION['csrf_tokens'][$formName] !== $token) {
          Flash::set("Erreur survenue.", "secondary");
          header("Location: $view");
          exit;
     }
    }

}