<?php
/**
 * @author Ryan H.
 * @file model/validate.php
 * @version https://github.com/rynhndrcksn/food-three
 * handles all of our validation functions for food app
 */

/**
 * returns true if not empty
 * @param $food
 * @return bool
 */
function validFood($food): bool {
	return !empty(prep_input($food));
}

/**
 * takes a parameter, strips any white spaces, strips \\'s and //'s, and converts any HTML to it's ASCII code.
 * is used on its own, but also acts as a helper function
 * @param $data
 * @return string
 */
function prep_input($data): string{
	$data = strtolower($data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}