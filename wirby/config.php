<?php

/**
 * Database
 */

c::set("db.host",     "webarchitects.at");
c::set("db.name",     "app_wirby");
c::set("db.user",     "wirby");
c::set("db.password", "wirby");
c::set("db.charset",  "utf8");

/**
 * System
 */

c::set("debug",       false); // only print debug
c::set("cache",       true);
c::set("cache_path",  "wirby/cache");
c::set("tmpls_path",  "pages"); // in project folder

/**
 * Dependencies
 * in "wirby/libs"
 */

c::set("lib_toolkit", "kirby-toolkit/kirby.php");
c::set("lib_tmpl",    "raintpl/inc/rain.tpl.class.php");
c::set("lib_mail",    "phpmailer/class.phpmailer.php");
c::set("lib_db",      "meekrodb/db.class.php");
c::set("lib_headjs",  "headjs/dist/head.load.min.js");
c::set("lib_ckeditor","ckeditor/ckeditor.js");

/**
 * Assets
 */

c::set("assets_loader",       "wirby/libs/".c::get("lib_headjs")); // library async loader
c::set("assets_callback",     "site_ready"); // afterwards execute this js-callback-function
c::set("assets_mapscallback", "maps_ready"); // after loading maps execute this one

c::set("assets_js", array( // js libraries used always
  "http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js",
  "http://maps.googleapis.com/maps/api/js?sensor=false&callback=".c::get("assets_mapscallback"),
  "wirby/libs/jquery.address.js"
));

c::set("assets_admin", array( // js libraries used when logged in
  "wirby/libs/ckeditor/ckeditor.js",
  "wirby/libs/jquery.jeditable.js",
  "wirby/libs/".c::get("lib_ckeditor"),
  "assets/script.js"
));

?>
