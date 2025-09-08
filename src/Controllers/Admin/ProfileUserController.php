<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Models\UserModel;
use Carbe\App\Controllers\BaseController;

class ProfileUserController extends BaseController {

    public function index(int $id) :void {

        $userModel = new UserModel($this->pdo);
        $user = $userModel->findById($id);



        $this->render('user_profile', [
            'title' => 'Petit Creux| Profil Utilisateur',
            'user' => $user
        ]);

    }

}