<?php 

namespace Carbe\App\Services;

class Flash {

    public static function set(string $message, string $type) {
        $_SESSION['flash'] = [
            "message" => $message,
            "type" => $type
        ];
    }

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