<?php 
namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Services\Auth;

class DashboardController extends BaseController {

    public function index() :void {
        
        Auth::isAdmin();

        $this->render('dashboard',  [
            'title' => 'Petit Creux | Dashboard',
        
      ]);
    }
}