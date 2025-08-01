<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\SearchModel;

class SearchController extends BaseController {
    public function query() {
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
}

