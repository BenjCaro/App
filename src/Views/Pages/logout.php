<?php
namespace Carbe\App\Views\Pages;

session_start();
// message flash ici
unset($_SESSION['user']);

session_destroy();

header("Location: /");
exit();


?>