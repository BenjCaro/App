<?php 
namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Controllers\UserController;
use Carbe\App\Models\UserModel;
use Carbe\App\Services\Auth;

class DashboardController extends BaseController {

    public function index() :void {
        
      Auth::isAdmin();
        
      $adminId = $_SESSION['auth_user']['id'];
      $adminModel = new UserModel($this->pdo);
      $admin = $adminModel->findById($adminId);

      // afficher les nouveaux utilisateurs

      $userModel = new UserModel($this->pdo);
      $users = $userModel->getAllUsers();
      
      // afficher les nouvelles recettes
      // afficher les dernieres commentaires 

        
      $this->render('dashboard',  [
            'title' => 'Petit Creux | Dashboard',
            'admin' => $admin,
            'users' => $users
        
      ]);
    }
}