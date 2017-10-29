<?php
interface printerHTML
{
    public function printHTML();
}

abstract class elementHTML implements printerHTML {
    public $id;
    public $class;
    public function printHTML(){}
}
