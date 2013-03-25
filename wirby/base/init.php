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

function test($debug){
  echo "Wirby logger exits: \n";
  print_r( $debug ? $debug : new Time() );
  exit;
}

function logr(){
  // https://docs.google.com/spreadsheet/ccc?key=0AqmhzrmZU8kqdFJnd1NPSzY2NzFhUWFvamJkMmYwdUE#gid=0
  $messages = '?logID=agtzfmxvZy1kcml2ZXILCxIDTG9nGLmCBww';
  foreach (func_get_args() as $a) $messages .= ("&m%5B%5D=".urlencode($a));
  $fp = fsockopen("log-drive.appspot.com", 80);
  $h = "GET /logd$messages HTTP/1.1\r\n";
  $h .= "Host: log-drive.appspot.com\r\n";
  $h.= "Connection: Close\r\n\r\n";
  fwrite($fp, $h);
  fclose($fp);
}

function alternative($array, $key, $array2, $key2){
  if(! $array) $array = $array2; // fallback if even the main array does not exist
  if(! $array2) $array2 = $array; // alternative in another array, or in the same one
  if(! $key2) $key2 = $key; // just use the same as within the main array
  return a::get($array, $key, a::get($array2, $key2, false));
}

/**
 * Language
 */

function language(){
  //s::remove("language");
  $lang = r::get("lang", l::current()); // if it's set try it, otherwise use default
  l::change($lang); // checks if it's allowed and set it
  // check it with l::current()
}

/**
 * Database connect
 */

function database(){
  if(! db::connect() ){
    die("Wirby: database connection failed! check config file");
  } else { c::set("db.password", "***"); } // delete it caz it's unnecessary now

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

  // prepare localized routes
  $routes = c::get("routes");                                   // load all routes
  if(! $routes){ die("Wirby: routes are not defined"); }

  $i18n = $routes[c::get("site").".".l::current()];             // matched language
  $fall = $routes[c::get("site").".".c::get("language")];       // default language fallback
  if(!$fall) $fall = $routes[c::get("site")];                   // (n)one language at all
  if(!$fall && !$i18n){ die("Wirby: routes are missing for ".c::get("site")); } // nothing at all for this site
  c::set("routes_i18n", $i18n, $fall);

  // get internationalized page synonym (key)
  $page_default = c::get("ajax") ? false : c::get("start_page");  // ajax: no startpage, but all pages
  $page = r::get("page", $page_default); // alternative = no-ajax: startpage

  $route = alternative($i18n, $page, $fall, $page); // look for the given page
  if($route) $page = $route; // if it's found, use it internally

  c::set("page", $page); // eveything else is done in content
}

?>
