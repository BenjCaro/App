<?php

namespace Carbe\App\Controllers;

class BaseController {

    protected function render(string $view, array $data = []) {

        extract($data);
        require_once VIEW_PATH . '/Partials/header.php';
        require_once VIEW_PATH . '/Partials/banniere.php';
        require_once VIEW_PATH . '/' . $view . '.php';

        require_once VIEW_PATH . '/Partials/footer.php';

    }
}