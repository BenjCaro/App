<?php

namespace Carbe\App\Controllers;

class AboutController extends BaseController {
       
    public function displayAbout() :void {

        $this->render('Pages\about', [
            'title' => "A propos",
            
        ]);

    }
}