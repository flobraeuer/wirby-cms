<?php

$root = dirname(__FILE__);
require_once( "wirby/load.php");

$site = new Wirby();
echo $site->render();

?>
