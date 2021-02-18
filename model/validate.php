<?php
/**
 * @author Ryan H.
 * @file model/validate.php
 * @version https://github.com/rynhndrcksn/food-three
 * handles all of our validation functions for food app
 */

class Validate
{
	// fields
	private $_dataLayer;

	function __construct()
	{
		$this->_dataLayer = new DataLayer();
	}

	/**
	 * returns true if not empty and contains only letters
	 * @param $food
	 * @return bool
	 */
	function validFood($food): bool
	{
		return !empty($this->prep_input($food)) && ctype_alpha($this->prep_input($food));
	}

	/**
	 * returns true if $meal is a valid meal
	 * @param $meal
	 * @return bool
	 */
	function validMeal($meal): bool
	{
		return in_array($meal, $this->_dataLayer->getMeals());
	}

	/**
	 * returns true if $conds contains valid condiments
	 * @param $conds
	 * @return bool
	 */
	function validConds($conds): bool
	{
		foreach ($conds as $cond) {
			if (!in_array($cond, $this->_dataLayer->getCondiments())) {
				return false;
			}
		}
		return true;
	}

	/**
	 * takes a parameter, strips any white spaces, strips \\'s and //'s, and converts any HTML to it's ASCII code.
	 * is used on its own, but also acts as a helper function
	 * @param $data
	 * @return string
	 */
	function prep_input($data): string
	{
		$data = strtolower($data);
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}