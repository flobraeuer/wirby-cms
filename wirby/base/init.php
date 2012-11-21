<?php

/**
 * System
 */

date_default_timezone_set("Europe/Vienna");
error_reporting(E_ALL); // E_STRICT
ini_set("display_errors", true);
c::set("has_error", false); // error message
c::set("has_info", false);  // info msg
c::set("in_wirby", false);  // we opened the CMS
c::set("is_admin", false);  // we logged in sucessfully
s::start();

/**
 * Database
 */

function connect(){
  if(! db::connect() ){
    die("Wirby: database connection failed! check config file");
  } else { c::set("db.password", "***"); } // delete it caz it's unnecessary

  return db::connection();
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
 * Admin
 */

function session(){
  $request = r::get("type", "");

  if( $request == "logout"){
    s::remove("user");
  }
  elseif( $request == "login" && r::is_post() ){
    $user = r::get("user","");
    $pass = r::get("pass","");

    if( strlen($user) && strlen($pass) ){
      if($user=="celik" && $pass="erfolg"){
        s::set("user", array(
          $user,
          "Musa Celik"
        ));
      }
      else{ c::set("has_error", "Benutzer und Passwort passen nicht zueinander."); }
    }
    else{ c::set("has_error", "Bitte gib einen Benutzernamen und ein Passwort ein."); }
  }

  if( r::get("edit") ){
    c::set("in_wirby", true);
  }
  if( s::get("user") ){
    c::set("in_wirby", true);
    c::set("is_admin", s::get("user"));
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
