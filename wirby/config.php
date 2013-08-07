<?php

/**
 * Database
 */

c::set("db.host",     "webarchitects.at");
c::set("db.name",     "app_wirby");
c::set("db.user",     "wirby");
c::set("db.password", "wirby");
c::set("db.charset",  "utf8");

c::set("languages", array("de", "en", "es", "fr", "it") );
c::set("language", "de"); // default used in toolkit:2148

/**
 * System
 */

c::set("ajax",        false); // async if page variable is false
c::set("debug",       false); // only print debug
c::set("cache",       true);
c::set("cache_path",  "wirby/cache");
c::set("tmpls_path",  "pages"); // in project folder
c::set("tmpl_main",   "layout");
c::set("tmpl_ajax",   "ajax"); // without a layout
c::set("tmpl_head",   "head");
c::set("tmpl_body",   "body");
c::set("start_page",  "start"); // start page, set if ajax is false

/**
 * Dependencies
 * in "wirby/libs"
 */

c::set("lib_toolkit",   "kirby-toolkit/kirby.php");
c::set("lib_tmpl",      "raintpl/inc/rain.tpl.class.php");
c::set("lib_mail",      "phpmailer/class.phpmailer.php");
c::set("lib_db",        "meekrodb/db.class.php");
c::set("lib_uploader",  "fileuploader/server/php/php.php");
c::set("js_lib_headjs", "headjs/dist/head.load.min.js");
c::set("js_lib_editor", "ckeditor3/ckeditor.js");
c::set("js_lib_tmpl",   "icanhaz/ICanHaz.min.js");

/**
 * Assets
 */

c::set("assets_loader",       "/wirby/libs/".c::get("js_lib_headjs")); // library async loader
c::set("assets_callback",     "site_ready"); // afterwards execute this js-callback-function
c::set("assets_mapscallback", "maps_ready"); // after loading maps execute this one

c::set("assets_js", array( // js libraries used always
  "http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js",
  "http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=".c::get("assets_mapscallback"),
  "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js",
  "/wirby/libs/jquery-address/jquery.address-1.6.min.js",
  "/wirby/libs/".c::get("js_lib_tmpl"),
  "/wirby/libs/bootstrap/js/bootstrap.min.js",
  "/wirby/assets/datatable.bootstrap.js",
  "/wirby/assets/datatable.tabletools.min.js"
));

c::set("assets_admin", array( // js libraries used when logged in
  //"/wirby/libs/ckeditor/ckeditor.js",
  "/wirby/libs/fileuploader/client/js/jquery-plugin.js",
  //"/wirby/libs/jquery.jeditable.js",
  //"/wirby/libs/".c::get("js_lib_editor"),
  //"/wirby/libs/ckeditor3/adapters/jquery.js",
  "/wirby/assets/script.js"
));

/**
 * Stuff
 */

c::set("microsoft_verification", false);
c::set("google_analytics", false); // "UA-7082989-19");
c::set("google_plus", false);
c::set("adminbar_position", "bottom");

?>
