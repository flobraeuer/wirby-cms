<?php

function render(){
  global $root;
  c::set("cache_path",   $root."/".c::get("cache_path")."/" ); // cache directory (default in wirby folder)
  c::set("tmpls_path",   $root."/".c::get("site")."/".c::get("tmpls_path")."/" ); // template dir in project folder
  c::set("tmpls_intern", $root."/"."wirby/assets/");

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
   * Assignments
   */

  $tmpls->assign( c::get() ); // whole info store
  $tmpls->assign( "cms", false );     // we are here in the cms
  $tmpls->assign( "admin", false );   // if logged in
  $tmpls->assign( "user", "" );       // user name
  $tmpls->assign( "date", date("His") );  // cache

  /**
   * Content
   */

  $contents_raw = db::select( "contents", array("title","content") ); //, array("site" => c::get("site"))
  $contents = array();
  foreach ($contents_raw as $content) { // map the result
    $contents[$content["title"]] = $content["content"];
  };

  $tmpls->assign( "content", $contents );

  /**
   * Render
   */

  $html = $tmpls->draw( "layout", $return_string = true );

  if(! c::get("function_head")) die("Wirby: you have to include Wirby's head in your templates, use this: {function='_head()'}");
  if(! c::get("function_body")) die("Wirby: you have to include Wirby's body in your templates, use this: {function='_body()'}");
  // this is executed inside the template in the function above (everything is prozedural)

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

function _head($template="_head"){
  c::set("function_head", true);
  $tmpls_intern = new RainTPL();
  $tmpls_intern->assign(c::get());
  $tmpls_intern->configure( "tpl_dir", c::get("tmpls_intern") ); // attention: that's global inside raintpl.php
  echo $tmpls_intern->draw( $template, $return_string = true ); // so after reconfig the site-tmpls' path is wrong
  $tmpls_intern->configure( "tpl_dir", c::get("tmpls_path") ); // workaround
}

function _body(){
  c::set("function_body", true);
  _head("_body");
}

// Caching
// $head = $tpl->cache( 'head', $expire_time = 600, $cache_id=1 );
// $body = $tpl->cache( 'body', $expire_time = 600, $cache_id=2 );

?>
