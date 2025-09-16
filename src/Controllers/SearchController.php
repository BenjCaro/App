<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\SearchModel;
use Carbe\App\Models\UserModel;
use Carbe\App\Models\RecipeModel;
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

    public function adminQuery() :void
{
    Auth::isAdmin();

    $search = $_GET["q"] ?? "";
    $type   = $_GET["type"] ?? "user"; // valeur par défaut

    $results = [];

    if ($search) {
        switch ($type) {
            case "user":
                $model = new UserModel($this->pdo);
                $results = $model->findUserWithName($search);
                break;

            case "recipe":
                $model = new RecipeModel($this->pdo);
                $results = $model->searchRecipeWithTitle($search);
                break;

            // case "category":
            //     $model = new CategoryModel($this->pdo);
            //     $results = $model->findCategoryWithName($search);
            //     break;

            default:
                $results = [];
        }
    }

    $this->render('search_results', [
        "title"   => 'Petit Creux | Résultats de la recherche',
        "type"    => $type,
        "results" => $results
    ]);
}

}

