<?php

class Order
{
	// fields
	private $_food;
	private $_meal;
	private $_condiments;

	/**
	 * @return string
	 */
	public function getFood(): string
	{
		return $this->_food;
	}

	/**
	 * @param string $food
	 */
	public function setFood(string $food)
	{
		$this->_food = $food;
	}

	/**
	 * @return string
	 */
	public function getMeal(): string
	{
		return $this->_meal;
	}

	/**
	 * @param string $meal
	 */
	public function setMeal(string $meal)
	{
		$this->_meal = $meal;
	}

	/**
	 * @return string
	 */
	public function getCondiments(): string
	{
		return $this->_condiments;
	}

	/**
	 * @param string $condiments
	 */
	public function setCondiments(string $condiments)
	{
		$this->_condiments = $condiments;
	}


}
