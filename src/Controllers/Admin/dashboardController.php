<?php 
namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\UserModel;
use Carbe\App\Services\Auth;

class DashboardController extends BaseController {

    public function index() :void {
        
      Auth::isAdmin();
        
       $adminId = $_SESSION['auth_user']['id'];
       $admin = new UserModel($this->pdo);
       $admin->findById($adminId);
        
        $this->render('dashboard',  [
            'title' => 'Petit Creux | Dashboard',
            'admin' => $admin
        
      ]);
    }
}