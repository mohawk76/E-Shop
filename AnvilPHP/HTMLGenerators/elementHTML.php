<?php

namespace AnvilPHP\HTMLGenerators;

abstract class elementHTML implements printerHTML {
    public $id;
    public $class;
    public function printHTML(){}
}