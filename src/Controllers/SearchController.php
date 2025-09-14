<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\SearchModel;
use Carbe\App\Models\UserModel;
use Carbe\App\Services\Auth;

class SearchController extends BaseController {
   
    public function query() :void {
        $search = $_GET['q'] ?? '';

        $model = new SearchModel($this->pdo);

        
        $recipes = [];
        $totalResults = 0;

        if ($search) {
            $data = $model->getRecipeWithTitle($search);
            $recipes = $data['recipes'];
            $totalResults = $data['totalResults'];
        }

        $this->render('Pages/search', [
            'title' => 'Petit Creux | Résultats de recherches',
            'results' => $recipes,
            'totalResults' => $totalResults,
            'search' => $search
        ]);
    }

    public function adminQuery() :void {

        Auth::isAdmin();

        $search = $_GET["q"] ?? "";

        $query = new UserModel($this->pdo);

        $users = [];

        if($search) {
            $users = $query->findUserWithName($search);
            
        }

        $this->render('search_user', [
            "title" => 'Petit Creux | Résultats de la recherche',
            'users' => $users
        ]);
    }
}

