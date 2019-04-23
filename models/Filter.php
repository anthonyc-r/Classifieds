<?php

namespace WebApp\Model;

class Filter {
	private $minPrice = NULL;
	private $maxPrice = NULL;
	private $maxDistance = NULL;
	private $userName = NULL;
	
	function __construct($minPrice, $maxPrice, $maxDist, $userName) {
		$this->minPrice = $minPrice;
		$this->maxPrice = $maxPrice;
		$this->maxDistance = $maxDist;
		$this->userName = $userName;
		$this->validate() or die("Invalid filter parameters");
	}
	
	public function getMaxPrice() {
		return $this->maxPrice;
	}
	
	public function getMinPrice() {
		return $this->minPrice;
	}
	
	public function getMaxDistance() {
		return $this->maxDistance;
	}
	
	public function getUserName() {
		return $this->userName;
	}
	
	public function isEmpty() {
		return !$this->minPrice  && 
			   !$this->maxPrice &&
			   !$this->maxDistance &&
			   !$this->userName;
	}
	
	public function validate() {
		return !$this->minPrice || is_numeric($this->minPrice) &&
			   !$this->maxPrice || is_numeric($this->maxPrice) &&
			   !$this->maxDistance || is_numeric($this->maxDistance) &&
			   (!$this->maxPrice || !$this->minPrice) || ($this->maxPrice >= $this->minPrice);
	}
}
?>
