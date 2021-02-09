<?php
/*
 * @author: Ryan H.
 * @version: https://github.com/rynhndrcksn/food-two
 * index.php is the controller for our F3 MVC
 */

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// create a session
session_start();

// require autoload file
require_once ('vendor/autoload.php');

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();

// turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// define a default route (home page)
$f3->route('GET /', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/home.html');
});

// define an order route
$f3->route('GET /order', function() {
	$view = new Template();
	echo $view->render('views/order.html');
});

// we can only use POST if the form method is POST, otherwise we need to use GET as GET is used for typing in the
// URL, hyperlinks, and most other things
// define an order2 route
$f3->route('POST /order2', function() {
	// gather info from order
	if (isset($_POST['food'])) {
		$_SESSION['food'] = $_POST['food'];
	}
	if (isset($_POST['meal'])) {
		$_SESSION['meal'] = $_POST['meal'];
	}
	$view = new Template();
	echo $view->render('views/order2.html');
});

// define an order route
$f3->route('POST /summary', function() {
	// gather info from order2
	if (isset($_POST['condiments'])) {
		$_SESSION['condiments'] = implode(', ', $_POST['condiments']);
	} else {
		$_SESSION['condiments'] = 'none';
	}

	echo '<pre>';
	var_dump($_SESSION);
	echo '</pre>';

	$view = new Template();
	echo $view->render('views/summary.html');
});

// run fat free HAS TO BE THE LAST THING IN FILE
$f3->run();
