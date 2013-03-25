<?php

function render(){
  global $root;
  // c::set("cache_path", $root."/".c::get("cache_path")."/" ); // cache directory (default in wirby folder)
  c::set("tmpls_path", $root."/".c::get("site")."/".c::get("tmpls_path")."/" ); // template dir in project folder
  c::set("wirby_path", $root."/"."wirby/assets/"); // template dir for internal wirby dom

  /**
   * Content
   */

  $contents_raw = db::select( "contents_".c::get("site"), array("title", "content") );
  $contents = array();
  foreach ($contents_raw as $content) { // map the result
    $contents[$content["title"]] = $content["content"];
  };
  c::set("content", $contents); // push it to the c class

  /**
   * Render
   */

  content::type("html");
  content::start();

  if(r::is_ajax() && r::get("type") == "content"){ // get whole page, not an admin call
    wirby::load(c::get("tmpl_ajax"), false);
  }
  else {
    wirby::load(c::get("tmpl_main"), false); // false: do not return, but echo

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

  // wirby header template with meta, css, js
  static function head(){
    c::set("function_head", true);
    self::load(c::get("tmpl_head"), c::get("wirby_path"));
  }
  // wirby body template after header with admin bar, js
  static function body(){
    c::set("function_body", true);
    self::load(c::get("tmpl_body"), c::get("wirby_path"));
  }

  // wirby config getter
  static function c($config, $child){
    $val = c::get($config,false);
    if(! $val) $val = s::get($config,false); // look for it in our session store
    if($child) $val = $val[$child]; // http://lucdebrouwer.nl/stop-waiting-start-array-dereferencing-in-php-now/
    return $val;
  }
  // return site/project name
  static function site(){ return c::get("site"); }

  // check url against a certain/current page
  static function is($page, $class="active"){
    return $page==c::get("page") ? $class : "";
  }
  // check if an admin successfully signed in
  static function is_a(){ return c::get("is_admin"); }
  // check if we are in the admin interface (not signed in for sure)
  static function in_a(){ return c::get("in_admin"); }

  // complete an url with language key (if it's not the default lang)
  static function to($page){
    $to = array_search($page, c::get("routes_i18n"));
    return $to ? $to : $page;
  }

  // change language (find current page in the other lang)
  static function to_lang($lang){
    $lang = l::sanitize($lang); // check if it is "able"
    $routes = c::get("routes"); // get the certain array
    $routes = $routes[c::get("site").".".$lang];
    if($routes) $to = array_search(c::get("page"), $routes); // try to get the local one
    if(! $to)   $to = array_search(c::get("page"), c::get("routes_i18n")); // fallback
    return $lang == c::get("language") ? "/".$to : "/".$lang."/".$to; // avoid 2 urls for 1 content
  }

  // load certain template
  static function load($name, $path=false){
    $file = self::find($name, $path);
    if($file) content::load( $file, false );
    else echo "Error 404 '".$path.$name."' nicht gefunden";
  }
  // find template file
  static function find($name, $path=false){
    if(!$path) $path = c::get("tmpls_path");
    $file = $path.$name; // probably it's a right filepath
    if(! f::size($file) ) $file = $path.$name.".html";
    if(! f::size($file) ) $file = $path.$name.".php";
    if(! f::size($file) ) $file = $path."_".$name.".html";
    if(! f::size($file) ) $file = $path."_".$name.".php";
    return f::size($file) ? $file : false;
  }

  // complete path of an developed asset
  static function asset($asset){
    return self::path("assets/$asset");
  }
  // complete path of an uploaded file
  static function file($file){
    return self::path("files/$file");
  }
  // whole absolute path
  static function path($ressource){
    return "/".c::get("site")."/$ressource";
  }
  // whole url, e.g. url(asset("style.css"))
  static function url($ressource){
    if($ressource[0] != "/") $ressource = "/$ressource"; // check if there is a delimiter
    return c::get("base_url") . $ressource; // just attach the path
  }

  // get the content of a db entry
  static function get($content, $alt, $pre){
    $array = c::get("content");
    $text = $array["$content"];
    return $text ? ($pre ? $pre : "").$text : ($alt ? $alt : $content);
  }

  // elements with end tags
  static function tag($tag, $content, $class, $attrs=""){
    $class = $class ? " class='$class'" : "";
    $attrs = $attrs . (c::get("is_admin") ? " data-wirby='$content'" : "");
    return "<$tag $class $attrs>" . self::get($content) . "</$tag>";
  }
  // image tag with fallback and dimensions, wrapper
  static function img_tag($content, $w, $h, $class, $attrs=""){
    $class = $class ? " class='$class'" : "";
    $attrs = $attrs . (c::get("is_admin") ? " data-wirby='$content'" : "");
    $attrs = $attrs . ($w ? " width='$w'" : "") . ($h ? " height='$h'" : ""); // style='".($w?" width:".$w."px;":"").($h?" height:".$h."px;":"")."'
    $src = self::get($content, "http://placehold.it/".($w?"$w":"200").($h?"x$h":"")."&text=$content");
    return "<div class='img'><img $class $attrs src='$src' /></div>";
  }
  static function h1($content, $class, $attrs){ return self::tag("h1", $content, $class, $attrs); }
  static function h2($content, $class, $attrs){ return self::tag("h2", $content, $class, $attrs); }
  static function h3($content, $class, $attrs){ return self::tag("h3", $content, $class, $attrs); }
  static function h4($content, $class, $attrs){ return self::tag("h4", $content, $class, $attrs); }
  static function h5($content, $class, $attrs){ return self::tag("h5", $content, $class, $attrs); }
  static function h6($content, $class, $attrs){ return self::tag("h6", $content, $class, $attrs); }
  static function p ($content, $class, $attrs){ return self::tag("p",  $content, $class, $attrs); }
  static function div($content, $class, $attrs){ return self::tag("div", $content, $class, $attrs); }
  static function span($content, $class, $attrs){ return self::tag("span", $content, $class, $attrs); }
  static function a ($content, $url="#", $class, $attrs=""){ return self::tag("a", $content, $class, $attrs." href='$url'"); }
  static function img ($content, $alt="", $w, $h, $class, $attrs=""){ return self::img_tag($content, $w, $h, $class, $attrs." alt='$alt'"); }
}

class w extends wirby {
  // shorthand
}

?>
