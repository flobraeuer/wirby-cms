<?php

function render(){
  global $root;
  c::set("cache_path", $root."/".c::get("cache_path")."/" ); // cache directory (default in wirby folder)
  c::set("tmpls_path", $root."/".c::get("site")."/".c::get("tmpls_path")."/" ); // template dir in project folder
  c::set("wirby_path", $root."/"."wirby/assets/"); // template dir for internal wirby dom

  /**
   * Engine
   */

  $tmpls = new RainTPL; // new RainTPL engine
  $tmpls->configure( "tpl_dir",      c::get("tmpls_path") );
  $tmpls->configure( "cache_dir",    c::get("cache_path") );
  $tmpls->configure( "path_replace", false );
  // $tmpl->configure( "path_replace_list", array("a", "img", "link", "script") );
  // $tmpl->configure( "base_url", c::get("base_url") );

  /**
   * Content
   */

  $contents_raw = db::select( "contents", array("title", "content"), array("site" => c::get("site")) );
  $contents = array();
  foreach ($contents_raw as $content) { // map the result
    $contents[$content["title"]] = $content["content"];
  };
  c::set("content", $contents); // push it to the c class

  /**
   * Assignments
   */

  $tmpls->assign( c::get() ); // whole info store
  $tmpls->assign( "cms", false );     // we are here in the cms
  $tmpls->assign( "admin", false );   // if logged in
  $tmpls->assign( "user", "" );       // user name
  $tmpls->assign( "date", date("His") );  // cache

  /**
   * Render
   */

  $html = $tmpls->draw( c::get("tmpls_main"), $return_string = true );

  if(! c::get("function_head")) die("Wirby: you have to include Wirby's head in your templates, use this: {function='_head()'}");
  if(! c::get("function_body")) die("Wirby: you have to include Wirby's body in your templates, use this: {function='_body()'}");
  // _head and _body are executed inside the template inside this draw function above (everything is prozedural!)

  return $html;
}

/**
 * Helpers
 */

function asset_url($file){
  echo c::get("base_url")."/".c::get("site")."/assets/".$file;
}

function asset_path($file){
  echo "/".c::get("site")."/assets/".$file;
}

function tmpl_wirby($template){
  $wirby_tmpl = new RainTPL();       // it's not possible to access an static var with 'c::get' or 'global $tmpl'
  $wirby_tmpl->assign( c::get() );   // therefore we have to reassign it to the new instance
  $wirby_tmpl->configure( "tpl_dir", c::get("wirby_path") );  // attention: that's global inside raintpl.php
  echo $wirby_tmpl->draw( $template, $return_string = true ); // so after reconfig the site-tmpls' path is wrong
  $wirby_tmpl->configure( "tpl_dir", c::get("tmpls_path") );  // workaround
}

function _head(){
  c::set("function_head", true);
  tmpl_wirby("_head");
}

function _body(){
  c::set("function_body", true);
  tmpl_wirby("_body");
}

// Caching
// $head = $tpl->cache( 'head', $expire_time = 600, $cache_id=1 );
// $body = $tpl->cache( 'body', $expire_time = 600, $cache_id=2 );

?>
