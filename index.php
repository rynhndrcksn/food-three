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
require_once ('model/data-layer.php');
require_once ('model/validate.php');

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
$f3->route('GET|POST /order', function($f3) {

	// if the form has been submitted
	if ($_SESSION['REQUEST_METHOD'] == 'POST') {
		// gather info from order and validate it
		if (validFood($_POST['food'])) {
			$_SESSION['food'] = $_POST['food'];
		} else {
			$f3->set('errors["food"]', 'Food cannot be blank');
		}
		if (validFood($_POST['meal'])) {
			$_SESSION['meal'] = $_POST['meal'];
		}

		// if there are no errors, redirect to /order2
		if (empty($f3->get('errors'))) {
			$f3-reroute('/order2');
		}
	}

	$f3->set('meals', getMeals());

	$view = new Template();
	echo $view->render('views/order.html');
});

// we can only use POST if the form method is POST, otherwise we need to use GET as GET is used for typing in the
// URL, hyperlinks, and most other things
// define an order2 route
$f3->route('GET|POST /order2', function($f3) {

	$f3->set('condiments', getCondiments());


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
