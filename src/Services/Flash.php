<?php 

namespace Carbe\App\Services;

class Flash {   

/**
* Stocke un message flash en session.
*
* @param string $message Le message à afficher
* @param string $type correspond à la classe css Bootstrap (ex: 'success', 'error', 'secondary')
*
* @return void
*/


    public static function set(string $message, string $type) :void  {
        $_SESSION['flash'] = [
            "message" => $message,
            "type" => $type
        ];
    }

/**
* Récupère et supprime le message flash stocké en session.
*
* @return array{message: string, type: string}|null

*/

      public static function get(): ?array
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']); 
        return $flash;
    }

}