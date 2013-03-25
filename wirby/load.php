<?php

if(!isset($root)) die("Wirby: Please add '$root = dirname(__FILE__);' before you require Wirby's load.php");
if(floatval(phpversion()) < 5.2) die("Wirby: Please upgrade to PHP 5.2+ which is necessary for its dependencies");

$libs = $root."/wirby/libs";

require_once( $libs."/kirby-toolkit/kirby.php" );

/**
 * Configs
 */

require_once( $root."/wirby/config.php" );
require_once( $root."/routes.php" );

/**
 * Dependencies
 */

require_once( $libs."/".c::get("lib_mail") );
require_once( $libs."/".c::get("lib_uploader") );

/**
 * Base logic
 */

require_once( $root."/wirby/wirby.php" );

?>
