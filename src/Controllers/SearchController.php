<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\SearchModel;

class SearchController extends BaseController {
    public function query() {
        $search = $_GET['q'] ?? '';

        $model = new SearchModel($this->pdo);
        $results = [];

        if ($search) {
            $results = $model->getRecipeWithTitle($search);
        }

        $this->render('Pages/search', [
            'title' => 'Petit Creux | Résultats de recherches',
             'results' => $results
        ]);
    }
}
