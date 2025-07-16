<?php
namespace Carbe\App\Controllers;

class SigninController extends BaseController {

        public function index() :void {
             
                $this->render('Users/inscription', [
                    'title' => 'Inscription',

                ]);
             
        }

}