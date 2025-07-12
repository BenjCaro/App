<?php

namespace Carbe\App\Controllers;


class LoginController extends BaseController {
      
     public function displayLogin() :void {
          
        $this->render('Users\login', [
                'title' => 'Connexion'
        ]);
     }
}

