<?php
$includes = array(
   'AnvilPHP/Collection.php',
   'AnvilPHP/Database.php',
   'AnvilPHP/Enum.php',
   'AnvilPHP/Form.php',
   'AnvilPHP/GetAndPost.php',
   'AnvilPHP/PrinterHTML.php',
   'AnvilPHP/SearchEngine.php',
   'AnvilPHP/Session.php',
);

foreach ($includes as $include)
{
    require_once $include;
}