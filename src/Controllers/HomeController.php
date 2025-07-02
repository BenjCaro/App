<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\config\Database;
use Carbe\App\Models\UserModel;



class HomeController extends BaseController {

  // connexion database ;)


    public function index() {

      $bdd = new Database();
      $pdo = $bdd->connectDB();

      // affichage des favoris de l'utilisateur connecté

      $userModel = new UserModel($pdo);

     $user = $userModel->findById(1);  // $user est maintenant un UserModel hydraté
     $favoris = $user ? $user->getFavoris() : [];


      // affiche derniere recette ajoutée
      // affiche les recettes avec le plus de favoris
      // afficher les catégories findAll

      $this->render('home',  [
        'title' => 'Petit Creux',
        'user' => $user,
        'favoris' => $favoris

      ]);

    }
}