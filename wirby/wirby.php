<?php

date_default_timezone_set("Europe/Vienna");
if($debug = true){
  error_reporting(E_STRICT); // E_ALL
  ini_set("display_errors", true);
}
c::set("has_error", false); // error message
c::set("has_info", false);  // info msg
c::set("in_wirby", false);  // we opened the CMS
c::set("is_admin", false);  // we logged in sucessfully
s::start();

class Wirby {

  function __construct() {
    self::log("Wirby loaded");
    $this->language();       // init: language from server
    $this->route();          // init: routing with localization
    $this->database();       // init: connect database
    $this->forms();          // forms: order, contact
    $this->session();        // admin: check admin session
    $this->admin();          // admin: render wirby
    return $this->render();  // content: render
  }

  /*****************************************************************************
   * System
   */

  static function test($debug){
    echo "Wirby logger exits: \n";
    print_r( $debug ? $debug : new Time() );
    exit;
  }

  static function log(){
    if($debug == true){
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
  }

  static function alternative($array, $key, $array2, $key2){
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
    $lang = r::get("lang", c::get("language")); // l::current() ... if it's set try it, otherwise use default
    l::change($lang); // checks if it's allowed and set it
    // check it with l::current()
    w::log("Language", $lang);
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
    $page = r::get("page"); // alternative = no-ajax: startpage
    if(!$page) $page = $page_default;

    $route = self::alternative($i18n, $page, $fall, $page); // look for the given page
    if($route) $page = $route; // if it's found, use it internally

    c::set("page", $page); // eveything else is done in content
  }

  function pad($str, $i=20, $pad=" ", $dir=STR_PAD_RIGHT){
    return "<b>".str_pad($str."", $i, $pad, $dir)."</b>"; //STR_PAD_LEFT
  }

  function forms(){
    $request = r::get("type", "");

    if( $request == "order" && r::is_post() ){
      if( $data = r::get("order",false) ){
        $w = 20;
        $s = " ";
        $msg = "<b>M&M Online Bestellung</b><br>";
        $msg .= "<i>Die Bestellung ist erfolgreich abgeschickt worden. Danke!</i>";
        $msg .= "<p style='font-family: Courier New;'>";
        $msg .= self::pad("Datum:").date("d.m.Y H:i:s")."<br>";
        $msg .= self::pad("Name:").$data["name"]."<br>";
        $msg .= self::pad("Firma:").$data["customer"]."<br>";
        $msg .= self::pad("Adresse:").$data["code"]." ".$data["town"].", ".$data["street"]."<br>";
        $msg .= self::pad("Telefon:").$data["number"]."<br>";
        $msg .= self::pad("Email:").$data["email"]."<br>";
        $msg .= self::pad("Computer:")."IP ".$_SERVER["REMOTE_ADDR"];//." (".$_SERVER["HTTP_USER_AGENT"].")";
        $msg .= "</p>";
        $msg .= "<i>Positionen der Bestellung:</i>";
        $msg .= "<p style='font-family: Courier New;'>";

        foreach($data["items"] as $i => $item){
          $msg .= "<i>".str_pad($i+1,2,"0",STR_PAD_LEFT).".</i> ".self::pad($item[0],40).$item[1]." ".$item[2]."<br>";
        }

        $msg .= "</p>";
        $msg .= "<i>Celik Gro&szlig;handel<br>+43 660 6522007</i>";

        $msg = str_replace("  ", "&nbsp;&nbsp;", $msg);
        self::mail("M&M Bestellung von ".$data["name"], $msg, $data["email"], $data["name"]);

        if( r::is_ajax() ){
          content::type("json");
          content::start();
          $info = array(
            "type" => "success",
            "msg" => $msg,
            "name" => $data["name"]
          );
          echo a::json($info);
          content::end(false);
          die();
        }
        else{
          //c::set("has_info", $length." ".($length>1?"Einträge":"Eintrag")." neu");
          //$track = track("content", $length.": ".$titles);
        }
      }
    }
  }

  function mail($subject, $msg, $to, $to_name){
    try {
      require_once('libs/phpmailer/class.phpmailer.php');
      $mail = new PHPMailer();

      $mail->AddAddress($to, $to_name);
      $mail->AddAddress("bestellung@celik-obstgemuese.at", "Bestellsystem");
      $mail->AddAddress("musa.celik1@hpeprint.com", "Bestellsystem");
      $mail->SetFrom("office@celik-obstgemuese.at", "Celik Obst Gemuese");
      // $mail->AddReplyTo($email["address"], $email["name"]);

      $mail->Subject = $subject;
      $mail->AltBody = $msg;
      $mail->CharSet = "utf-8";
      $mail->MsgHTML( $msg );

      $mail->IsSMTP();                // telling the class to use SMTP
      $mail->SMTPDebug = false;       // enables SMTP debug information (1 = errors and messages, 2 = messages only)
      $mail->SMTPAuth  = true;                          // enable SMTP authentication
      $mail->Host      = "wp266.webpack.hosteurope.de"; // SMTP server
      $mail->Username  = "wp10625343-bestellung";       // SMTP account username
      $mail->Password  = "proworx01";                   // SMTP account password

      $send = $mail->Send();
      return true;

    } catch (Exception $e) {
      echo a::json($json_encode( array("status" => "error", "msg" => ($e->getMessage()) ) ) );
      content::end(false);
      die();
    };
  }

  /*****************************************************************************
   * Administration
   */

  function session(){
    $request = r::get("type", "");

    if( $request == "logout"){
      s::remove("admin");
    }
    elseif( $request == "login" && r::is_post() ){
      $name = r::get("user","");
      $pass = r::get("pass","");

      if( strlen($name) && strlen($pass) ){
        $admin  =   db::row("users", array("name","user","lastip","lastlogin"), array("user"=>$name, "password"=>md5($pass)) );
        if($admin){ s::set("admin", $admin); }
        else{       c::set("has_error", "Benutzer und Passwort passen nicht zueinander."); }
      }
      else{ c::set("has_error", "Bitte gib einen Benutzernamen und ein Passwort ein."); }
    }

    c::set("in_admin", r::get("admin") || s::get("admin") ? true : false);
    c::set("is_admin", s::get("admin") ? true : false);
  }

  /**
   * Wirby CMS at all
   */

  function admin(){
    $request = r::get("type", "");
    $lang = l::current(); if(!$lang) $lang = c::get("language");

    if( $request == "update" && r::is_post() ){
      if( $contents = r::get("contents",false) ){

        $count = count($contents);
        $updated = 0;
        $inserted = 0;
        $changed = array();
        foreach($contents as $title => $content){
          $existing = db::row( "contents_".c::get("site"), array("id"), array("title" => $title, "lang" => $lang) );
          if($existing){
            $update = db::update( "contents_".c::get("site"), array("content" => $content), array("id" => $existing["id"], "lang" => $lang) );
            $updated ++;
          }else{
            $insert = db::insert( "contents_".c::get("site"), array("content" => $content, "title" => $title, "lang" => $lang) );
            $inserted ++;
          }
          $changed[] = $title;
        }

        if( r::is_ajax() ){
          content::type("json");
          content::start();
          $info = array(
            "type" => "success",
            "updated" => $updated,
            "inserted" => $inserted,
            "changed" => join(", ", $changed)
          );
          echo a::json($info);
          content::end(false);
          die();
        }
        else{
          c::set("has_info", $length." ".($length>1?"Einträge":"Eintrag")." neu");
          //$track = track("content", $length.": ".$titles);
        }
      }
    }
    elseif( $request == "upload" ){
      content::type("text/plain");
      content::start();
      $target = c::get("site")."/files/";

      // https://raw.github.com/valums/file-uploader/master/server/php.php
      $allowedExtensions = array("jpg", "jpeg", "png", "gif");
      $sizeLimit = 10 * 1024 * 1024; // max file size in bytes
      $inputName = 'qqfile'; //the input name set in the javascript
      // in lib_uploader (=fileuploader/server/php.php)
      $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $inputName);
      // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
      $result = $uploader->handleUpload( $target );
      // to pass data through iframe you will need to encode all html tags
      echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
      content::end(false);
      die();
    }
  }


  /*****************************************************************************
   * Content
   */

  function render(){
    global $root;
    // c::set("cache_path", $root."/".c::get("cache_path")."/" ); // cache directory (default in wirby folder)
    c::set("tmpls_path", $root."/".c::get("site")."/".c::get("tmpls_path")."/" ); // template dir in project folder
    c::set("wirby_path", $root."/"."wirby/assets/"); // template dir for internal wirby dom

    /**
     * Array
     */

    $contents_raw = db::select( "contents_".c::get("site"), array("title", "content", "lang") );
    $contents = array();
    foreach ($contents_raw as $content) { // map the result
      $lang = $content["lang"]; if(!$lang) $lang = c::get("language"); // default language
      $contents[$content["title"]][$lang] = $content["content"];
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
  static function page(){ return c::get("page"); }

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
    $to = $to ? $to : $page; // maybe this page doesn't exist
    $lang = l::current(); // also here it's necessary to avoid 2 urls for 1 content
    return $lang == c::get("language") ? "/".$to : "/".$lang."/".$to;
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
    $contents = c::get("content");
    $matching = $contents["$content"][l::current()];  // prefered lang
    if(!$matching) $matching = $contents["$content"][c::get("language")]; // default lang
    return $matching ? ($pre ? $pre : "").$matching : ($alt ? $alt : $content);
  }

  // elements with end tags
  static function tag($tag, $content, $class, $attrs=""){
    $class = $class ? " class='$class $content'" : "";
    $attrs = $attrs . (c::get("is_admin") ? " data-wirby='$content'" : "");
    return "<$tag $class $attrs>" . self::get($content) . "</$tag>";
  }
  // image tag with fallback and dimensions, wrapper
  static function img_tag($content, $w, $h, $class, $attrs=""){
    $class = $class ? " class='$class $content-img'" : "";
    $attrs = $attrs . (c::get("is_admin") ? " data-wirby='$content'" : "");
    $attrs = $attrs . ($w ? " width='$w'" : "") . ($h ? " height='$h'" : "");
    $attr = "style='".($w ? " width:".$w."px;":"").($h?" height:".$h."px;":"")."'";
    $src = self::get($content, "http://placehold.it/".($w?"$w":"200").($h?"x$h":"")."&text=$content");
    return "<div class='img $content' $attr><img $class $attrs src='$src' /></div>";
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
