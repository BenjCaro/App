<?php
namespace Carbe\App\Views\Pages;

session_start();

session_unset();

session_destroy();
// message flash ici
header("Location: /");
exit();


?>