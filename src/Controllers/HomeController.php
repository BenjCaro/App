<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\config\Database;



class HomeController extends BaseController {

    public function index() {

      // affichage des favoris 
      // affiche derniere recette ajoutée
      // affiche les recettes avec le plus de favoris
      // afficher les catégories

      $this->render('home',  [
        'title' => 'Petit Creux',

      ]);

    }
}