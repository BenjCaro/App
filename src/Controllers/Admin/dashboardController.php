<?php 
namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;

class DashboardController extends BaseController {

    public function index() :void {
        if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

        $this->render('dashboard',  [
        'title' => 'Petit Creux | Dashboard',
        
      ]);
    }
}