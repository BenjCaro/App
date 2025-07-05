<?php 

require_once __DIR__ . '/../vendor/autoload.php';
define('VIEW_PATH', dirname(__DIR__) . '/src/Views');


// use Carbe\App\Controllers\HomeController;

//  $home = new HomeController();
//  $home->index();


$router= new AltoRouter();

require __DIR__ . '/../routes/web.php';

$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] );
} else {
	
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}




 