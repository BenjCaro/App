<?php

namespace Carbe\App\Controllers;


class LoginController extends BaseController {
      
     public function displayLogin() {
          
        $this->render('Users\login', [
                'title' => 'Connexion'
        ]);
     }
}

?> 