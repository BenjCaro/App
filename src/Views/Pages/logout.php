<?php
namespace Carbe\App\Views\Pages;
session_start();


unset($_SESSION['auth_user']); 
$_SESSION['flash'] = "Déconnexion réussie.";
header("Location: /login");
exit();



?>