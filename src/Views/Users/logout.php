<?php
namespace Carbe\App\Views\Pages;
use Carbe\App\Services\Flash;
session_start();
Flash::set("Déconnexion réussie", "primary");

header("Location: /");
exit();



?>