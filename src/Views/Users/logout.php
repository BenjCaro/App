<?php
namespace Carbe\App\Views\Pages;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Auth;
session_start();

Auth::offAuth();
Flash::set("Déconnexion réussie", "primary");

header("Location: /");
exit();



?>