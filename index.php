<?php
/*
 * @author: Ryan H.
 * @version: https://github.com/rynhndrcksn/food-two
 * index.php is the controller for our F3 MVC
 */

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require autoload file
require_once ('vendor/autoload.php');

// create a session
session_start();

// instantiate the classes
$f3 = Base::instance();
$validator = new Validate();
$dataLayer = new DataLayer();
$order = new Order();
$controller = new Controller($f3);

// turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// define a default route (home page)
$f3->route('GET /', function() use ($controller) {
	$controller->home();
});

// define an order route
$f3->route('GET|POST /order', function() use ($controller, $order, $dataLayer, $validator) {
	$controller->order();
});

// we can only use POST if the form method is POST, otherwise we need to use GET as GET is used for typing in the
// URL, hyperlinks, and most other things
// define an order2 route
$f3->route('GET|POST /order2', function($f3) use ($order, $validator, $dataLayer) {

	// TODO: Move all this stuff to controller.php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['condiments'])) {
			$userConds = $_POST['condiments'];
			if ($validator->validConds($userConds)) {
				// since our object is stored in $_SESSION, we can just set the condiments with implode
				$_SESSION['order']->setCondiments(implode(', ', $userConds));
			} else {
				$f3->set('errors["conds"]', 'Not a valid condiment!');
			}
		}
		$f3->reroute('summary');
	}

	$f3->set('condiments', $dataLayer->getCondiments());

	$view = new Template();
	echo $view->render('views/order2.html');
});

// define an order route
$f3->route('GET|POST /summary', function() {

	echo '<pre>';
	var_dump($_SESSION);
	echo '</pre>';

	$view = new Template();
	echo $view->render('views/summary.html');

	// clear the SESSION array
	session_destroy();
});

// run fat free HAS TO BE THE LAST THING IN FILE
$f3->run();
