<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Exception;
use Carbe\App\Models\UserModel;
use Carbe\App\Services\Flash;

class AdminController extends BaseController  {

        public function deleteUser(int $id) {


            $userModel = new UserModel($this->pdo);
            $user = $userModel->findById($id);

            if(!$user) {
                Flash::set('Utilisateur non trouvé.', 'secondary');
                exit;
            }

            try {
                
                $userModel->delete($id);
                Flash::set("Utilisateur supprimé avec succés !", "primary");
              
            }

            catch(Exception $e) {

                Flash::set("Erreur dans la suppression", "secondary");        
        }
        
        header('Location: /admin');
        exit;
    }


}