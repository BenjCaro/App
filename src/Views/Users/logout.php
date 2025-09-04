<?php
namespace Carbe\App\Views\Pages;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Auth;
session_start();

Auth::offAuth();
$_SESSION = [];
Flash::set("Déconnexion réussie, A bientôt", "primary");

header("Location: /");
exit();



?>