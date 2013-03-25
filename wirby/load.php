<?php

if(!isset($root)) die("Wirby: Please add '$root = dirname(__FILE__);' before you require Wirby's load.php");
if(floatval(phpversion()) < 5.2) die("Wirby: Please upgrade to PHP 5.2+ which is necessary for its dependencies");

$libs = $root."/wirby/libs";
$base = $root."/wirby/base";

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
//require_once( $libs."/".c::get("lib_tmpl") );

/**
 * Base logic
 */

require_once( $base."/init.php" );
require_once( $base."/admin.php" );
require_once( $base."/content.php" );

function wirby() {
  logr("Wirby loaded");
  language();       // init: language from server
  route();          // init: routing with localization
  database();       // init: connect database
  session();        // admin: check admin session
  admin();          // admin: render wirby
  return render();  // content: render
};

?>
