<?php
namespace Carbe\App\Controllers;

class SigninController extends BaseController {

        public function index() :void {
                session_start();
                $old = $_SESSION['old'] ?? [];

                unset($_SESSION['old']);
             
                $this->render('Users/inscription', [
                    'title' => 'Inscription',
                    'old' => $old

                ]);
             
        }

}