<?php

namespace Carbe\App\Controllers;

class AboutController extends BaseController {
       
    public function displayAbout() {

        $this->render('Pages\about', [
            'title' => "A propos",
            
        ]);

    }
}