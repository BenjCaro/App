<?php
namespace Carbe\App\Views\Pages;
session_start();

$_SESSION['flash'] = "Deconnexion";

unset($_SESSION['user']); 
$_SESSION['flash'] = "Déconnexion réussie.";
header("Location: /login");
exit();



?>