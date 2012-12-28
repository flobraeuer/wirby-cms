<?php

/**
 * System
 */

date_default_timezone_set("Europe/Vienna");
error_reporting(E_STRICT); // E_ALL
ini_set("display_errors", true);
c::set("has_error", false); // error message
c::set("has_info", false);  // info msg
c::set("in_wirby", false);  // we opened the CMS
c::set("is_admin", false);  // we logged in sucessfully
s::start();

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

  $page_default = c::get("ajax") ? false : c::get("start_page"); // ajax: no startpage, but all pages | no-ajax: startpage
  $page = r::get("page", $page_default);
  // find synonyms
  $pages = c::get("pages");
  if($pages) $pages = $pages[c::get("site")];
  if($pages) $synonym = $pages[$page];
  if($synonym) $page = $synonym;
  // eveything else is done in content
  c::set("page", $page);
}

/**
 * Database connect
 */

function database(){
  if(! db::connect() ){
    die("Wirby: database connection failed! check config file");
  } else { c::set("db.password", "***"); } // delete it caz it's unnecessary

  return db::connection();
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
