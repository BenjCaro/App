<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\UserModel;
use Carbe\App\Services\Auth;

class AllUsersController extends BaseController  {

    public function viewAllUsers() :void {

        Auth::isAdmin();
        
        $userModel = new UserModel($this->pdo);
        $users = $userModel->getAllUsers();


        $this->render('all_users', [

            'title' => 'Petit Creux | Tous les utilisateurs',
            'users' => $users
        ]);
    }}