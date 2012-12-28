<?php

function render(){
  global $root;
  // c::set("cache_path", $root."/".c::get("cache_path")."/" ); // cache directory (default in wirby folder)
  c::set("tmpls_path", $root."/".c::get("site")."/".c::get("tmpls_path")."/" ); // template dir in project folder
  c::set("wirby_path", $root."/"."wirby/assets/"); // template dir for internal wirby dom

  /**
   * Engine
   */

  // $tmpls = new RainTPL; // new RainTPL engine
  // $tmpls->configure( "tpl_dir",      c::get("tmpls_path") );
  // $tmpls->configure( "cache_dir",    c::get("cache_path") );
  // $tmpls->configure( "path_replace", false );
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

  // $tmpls->assign( c::get() ); // whole info store
  // $tmpls->assign( "cms", false );     // we are here in the cms
  // $tmpls->assign( "admin", false );   // if logged in
  // $tmpls->assign( "user", "" );       // user name
  // $tmpls->assign( "date", date("His") );  // cache

  // $html = $tmpls->draw( c::get("tmpls_ajax"), $return_string = true );
  // $html = $tmpls->draw( c::get("tmpls_main"), $return_string = true );

  /**
   * Render
   */

  content::type("html");
  content::start();

  if(r::is_ajax()){
    wirby::load(c::get("tmpl_ajax"), false); // false: do not return, but echo
  }
  else {
    wirby::load(c::get("tmpl_main"), false);

    if(! c::get("function_head")) die("Wirby: you have to include Wirby's head in your templates, use this: {function='_head()'}");
    if(! c::get("function_body")) die("Wirby: you have to include Wirby's body in your templates, use this: {function='_body()'}");
    // _head and _body are executed inside the template inside this draw function above (everything is prozedural!)
  };

  return content::end(false); // true: return echoed
}


/**
 * Helpers
 */

class wirby {
  static function head(){
    c::set("function_head", true);
    self::load(c::get("tmpl_head"), c::get("wirby_path"));
  }
  static function body(){
    c::set("function_body", true);
    self::load(c::get("tmpl_body"), c::get("wirby_path"));
  }
  static function load($name, $path=false){
    $file = self::find($name, $path);
    if($file) content::load( $file, false );
    else echo "Error 404 '".$path.$name."' nicht gefunden";
  }
  static function find($name, $path=false){
    if(!$path) $path = c::get("tmpls_path");
    $file = $path.$name; // probably it's a right filepath
    if(! f::size($file) ) $file = $path.$name.".html";
    if(! f::size($file) ) $file = $path.$name.".php";
    if(! f::size($file) ) $file = $path."_".$name.".html";
    if(! f::size($file) ) $file = $path."_".$name.".php";
    return f::size($file) ? $file : false;
  }
  static function c($config){
    return c::get($config,false);
  }
  static function asset($ressource){
    return "/".c::get("site")."/assets/".$ressource;
  }
  static function asset_url($ressource){
    return c::get("base_url")."/".c::get("site")."/assets/".$ressource;
  }
  static function is($page, $class="active"){
    return $page==c::get("page") ? $class : "";
  }
  static function to($page){
    $all = c::get("pages");
    if($all) $all = $all[c::get("site")];
    $to = array_search($page, $all);
    return $to ? $to : $page;
  }
  static function is_a(){ return c::get("is_admin"); }
  static function in_a(){ return c::get("in_admin"); }
  static function site(){ return c::get("site"); }

  static function get($content){
    $array = c::get("content");
    $text = $array[$content];
    return $text ? $text : "Noch nicht gesetzt";
  }
  static function tag($tag, $content, $args){
    $html = "<$tag";
    if($args) $html .= " $args";
    if(c::get("is_admin")) $html .= " data-wirby='true' id='$content'";
    $html .= ">".self::get($content)."</$tag>";
    return $html;
  }
  static function h1($content, $args){ return self::tag("h1", $content, $args); }
  static function h2($content, $args){ return self::tag("h2", $content, $args); }
  static function h3($content, $args){ return self::tag("h3", $content, $args); }
  static function h4($content, $args){ return self::tag("h4", $content, $args); }
  static function h5($content, $args){ return self::tag("h5", $content, $args); }
  static function h6($content, $args){ return self::tag("h6", $content, $args); }
  static function p ($content, $args){ return self::tag("p",  $content, $args); }
  static function div($content, $args){ return self::tag("div", $content, $args); }
  static function span($content, $args){ return self::tag("span", $content, $args); }
  static function a ($content, $url="#", $args=""){ return self::tag("a", $content, $args." href='$url'"); }

}

class w extends wirby {
  // shorthand
}

// function tmpl_wirby($template){
//   $wirby_tmpl = new RainTPL();       // it's not possible to access an static var with 'c::get' or 'global $tmpl'
//   $wirby_tmpl->assign( c::get() );   // therefore we have to reassign it to the new instance
//   $wirby_tmpl->configure( "tpl_dir", c::get("wirby_path") );  // attention: that's global inside raintpl.php
//   echo $wirby_tmpl->draw( $template, $return_string = true ); // so after reconfig the site-tmpls' path is wrong
//   $wirby_tmpl->configure( "tpl_dir", c::get("tmpls_path") );  // workaround
// }

// Caching
// $head = $tpl->cache( 'head', $expire_time = 600, $cache_id=1 );
// $body = $tpl->cache( 'body', $expire_time = 600, $cache_id=2 );

?>
