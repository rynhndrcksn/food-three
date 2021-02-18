<?php

/**
 * @author Ryan H.
 * @file model/data-layer.php
 * @version https://github.com/rynhndrcksn/food-three
 * data-layer.php is just our model class that does all the heavy lifting for us
 */

class DataLayer
{
	/**
	 * returns an array of meals
	 * @return string[]
	 */
	function getMeals(): array
	{
		return array('breakfast', 'lunch', 'dinner');
	}

	/**
	 * returns an array of condiments
	 * @return string[]
	 */
	function getCondiments(): array
	{
		return array('ketchup', 'mayonnaise', 'mustard', 'sriracha');
	}
}