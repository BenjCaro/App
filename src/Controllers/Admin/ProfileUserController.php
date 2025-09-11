<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Models\UserModel;
use Carbe\App\Models\PostModel;
use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Services\Auth;

class ProfileUserController extends BaseController {

    public function index(int $id) :void {

        Auth::isAdmin();

        $userModel = new UserModel($this->pdo);
        $user = $userModel->findById($id);

        $recipeModel = new RecipeModel($this->pdo);
        $recipes = $recipeModel->getRecipesByUser($id);
        $favoris = $user->getFavoris();

        $postModel = new PostModel($this->pdo);
        $posts = $postModel->getCommentsByUser($id);

        $this->render('user_profile', [
            'title' => 'Petit Creux | Profil Utilisateur',
            'user' => $user,
            'favoris' => $favoris,
            'recipes' => $recipes,
            'posts' => $posts
        ]);

    }

}