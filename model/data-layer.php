<?php
/**
 * @author Ryan H.
 * @file model/data-layer.php
 * @version https://github.com/rynhndrcksn/food-three
 * data-layer.php is just our model file that does all the heavy lifting for us
 */

function getMeals(): array {
	return array('breakfast', 'lunch', 'dinner');
}

function getCondiments() {
	return array('ketchup', 'mayonnaise', 'mustard', 'sriracha');
}