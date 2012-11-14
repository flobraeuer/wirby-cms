<?php

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
require_once( $libs."/".c::get("lib_tmpl") );

/**
 * Base logic
 */

require_once( $base."/init.php" );
require_once( $base."/tmpl.php" );
//require_once( "$path/". "mail" );

function wirby(){
  connect();
  route();

  return render();
}

?>
