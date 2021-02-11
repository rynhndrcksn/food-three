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
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userFood = prep_input($_POST['food']);
		$userMeal = prep_input($_POST['meal']);
		// gather info from order and validate it
		if (validFood($userFood)) {
			$_SESSION['food'] = $userFood;
		} else {
			$f3->set('errors["food"]', 'Food cannot be blank');
		}

		if (validMeal($userMeal)) {
			$_SESSION['meal'] = $userMeal;
		} else {
			$f3->set('errors["meal"]', 'Not a valid meal!');
		}

		// if there are no errors, redirect to /order2
		if (empty($f3->get('errors'))) {
			$f3->reroute('/order2');
		}
	}

	$f3->set('meals', getMeals());
	$f3->set('userFood', isset($userFood) ? $userFood : "");
	$f3->set('userMeal', isset($userMeal) ? $userMeal : "");

	$view = new Template();
	echo $view->render('views/order.html');
});

// we can only use POST if the form method is POST, otherwise we need to use GET as GET is used for typing in the
// URL, hyperlinks, and most other things
// define an order2 route
$f3->route('GET|POST /order2', function($f3) {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['condiments'])) {
			$userConds = $_POST['condiments'];
			if (validConds($userConds)) {
				$_SESSION['conds'] = implode(', ', $userConds);
			} else {
				$f3->set('errors["conds"]', 'Not a valid condiment!');
			}
		}
		$f3->reroute('summary');
	}

	$f3->set('condiments', getCondiments());

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
