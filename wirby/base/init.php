<?php

/**
 * System
 */

date_default_timezone_set("Europe/Vienna");
error_reporting(E_ALL); // E_STRICT
ini_set("display_errors", true);
c::set("has_error", false);
c::set("has_info", false);

/**
 * Database
 */

function connect(){
  if(! db::connect() ){
    die("Wirby: database connection failed! check config file");
  } else { c::set("db.password", "***"); } // delete it

  $data = db::connection();
}

/**
 * Routing
 */

function route(){
  c::set("url", url::current() );
  c::set("base_url", rtrim(url::strip_hash( url::strip_query(c::get("url")) ), "/") );
  c::set("domain", url::short( c::get("url"), false, true, "") );

  if( $domains = c::get("domains") ){       // all domains for several projects
    foreach( $domains as $domain => $name ){
      if( $domain == c::get("domain") ){    // if there is one matching the current one
        c::set("site", $name);              // this project's folder
      }
    }
    if(!c::get("site") ){                   // the folder info is necessary for Wirby
      die("Wirby: the current domain '".c::get("domain")."' is not specified in your routes.php file.");
    }
  }
  else {                                    // there are no domains at all
    die("Wirby: please create a routes.php file and specify domains over there.");
  }
}

/**
 * Debugging
 */

function test($debug){
  echo "Wirby logger exits: \n";
  print_r( $debug );
  exit;
}

?>
