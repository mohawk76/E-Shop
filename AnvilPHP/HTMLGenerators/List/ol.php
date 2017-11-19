<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AnvilPHP\HTMLGenerators\ListHTML;

class ol extends \AnvilPHP\HTMLGenerators\elementHTML {
	public $li;
	
	public function __construct() {
		$this->li = new \AnvilPHP\HTMLGenerators\ElementsCollection();
	}
}
