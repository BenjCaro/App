<?php

namespace Carbe\App\Controllers;


class LoginController extends BaseController {
      
     public function displayLogin() :void {

        session_start();
        $old = $_SESSION['old'] ?? [];

        unset($_SESSION['old']);
          
        $this->render('Users\login', [
                'title' => 'Connexion',
                'old' => $old
        ]);
     }
}

