<?php

class Controller
{ // 🤮
	// field that contains our F3 object
	private $_f3;

	function __construct($f3)
	{
		$this->_f3 = $f3;
	}

	/**
	 * display home.html
	 */
	public function home()
	{
		// create a new view, then sends it to the client
		$view = new Template();
		echo $view->render('views/home.html');
	}

	/**
	 * display order.html
	 */
	public function order()
	{
		global $validator;
		global $order;
		global $dataLayer;

		// if the form has been submitted
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$userFood = $_POST['food'];
			$userMeal = $_POST['meal'];
			// gather info from order and validate it
			if ($validator->validFood($userFood)) {
				$order->setFood($userFood);
			} else {
				$this->_f3->set('errors["food"]', 'Food cannot be blank');
			}

			if ($validator->validMeal($userMeal)) {
				$order->setMeal($userMeal);
			} else {
				$this->_f3->set('errors["meal"]', 'Not a valid meal!');
			}

			// if there are no errors, redirect to /order2
			if (empty($this->_f3->get('errors'))) {
				$_SESSION['order'] = $order;
				$this->_f3->reroute('/order2');
			}
		}

		$this->_f3->set('meals', $dataLayer->getMeals());
		$this->_f3->set('userFood', isset($userFood) ? $userFood : "");
		$this->_f3->set('userMeal', isset($userMeal) ? $userMeal : "");

		$view = new Template();
		echo $view->render('views/order.html');
	}
}