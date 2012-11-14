<?php

  // Session
  session_start();

  c::set("path", "wirby");


  // Initials
  date_default_timezone_set("Europe/Vienna");
  error_reporting(E_ALL/*E_STRICT*/);
  ini_set("display_errors", true);
  $site = "knotzer";
  $logged_in = false;
  $note = "";
  $alert = false;

  // Debugging
  if($d = false){
    print_r($_FILES);
    print_r($_POST);
    print_r($_SESSION);
  };
  function track($type, $note=""){
    $date = date("Y-m-d H:i:s");
    $user = isset($_SESSION["user"]) ? $_SESSION["user"][2] : 0;
    $addr = $_SERVER["REMOTE_ADDR"];
    $client = $_SERVER["HTTP_USER_AGENT"];
    try{
      if($type=="login") DB::update("users", array( "lastip" => $addr, "lastlogin" => $date ), "user=%s", $_SESSION["user"][0]);
      DB::insert("logs", array( "type" => $type, "user" => $user, "date" => $date, "ip" => $addr, "client" => $client, "note" => $note ) );
    }catch(Exception $e){ return false; }
    return true;
  };

  // Database
  require_once "meekrodb/meekrodb.1.6.class.php";
  DB::$user = "cust_knotzer";
  DB::$dbName = "cust_knotzer";
  DB::$password = "knotzer_geheim";
  DB::$encoding = "utf8";

  /**
   ** Login
   **/

  // Login
  if( isset($_POST["user"]) && isset($_POST["password"]) ){
    if($d) echo " > Login";
    $username = $_POST["user"];
    $password = $_POST["password"];
    if( strlen($username) && strlen($password) ){
      if($d) echo " > Data ok";
      $user = DB::queryFirstRow("SELECT id, user, name FROM users WHERE user=%s AND password=%s LIMIT 1", $username, md5($password));
      if( $user ){
        if($d) echo " > User ok";
        $_SESSION["user"] = array( $user["user"], $user["name"], $user["id"] );
        // Log
        $track = track("login");
        if($d) echo " > ".($track ? "Log tracked" : "Log failed");
      }
      else{ $alert = "Eingaben passen nicht zueinander"; track("failed", "$username:$password;" ); };
    } else  $alert = "Keine g&uuml;ltigen Eingaben";
  }
  // Change Password
  else if( isset($_POST["password"]) && isset($_SESSION["user"]) ){
    if($d) echo " > Password";
    $username = $_SESSION["user"][0];
    $password = $_POST["password"];
    if( strlen($password) >= 4){
      if($d) echo " > Data ok";
      $update = DB::update("users", array( "password" => md5($password) ), "user=%s", $username);
      $note = "Passwort geändert f&uuml;r ".$username;
      // Log
      $track = track("password");
      if($d) echo " > ".($track ? "Log tracked" : "Log failed");
    } else $alert = "Passwort zu kurz";
  }
  // Logout
  else if( isset($_GET["logout"]) ){
    if($d) echo " > Logout";
    $track = track("logout");
    if($d) echo " > ".($track ? "Log tracked" : "Log failed");
    session_unset("user");
    $note = "Abgemeldet";
  };

  // Session
  if(isset($_SESSION["user"])) {
    if($d) echo " > Session on";
    $admin = true;
    $user = $_SESSION["user"][1];
  } else {
    if($d) echo " > Session no";
    $admin = false;
    $user = "";
  }

  /**
   ** Content Changing
   **/

  // Files

  if( isset($_FILES["images"]) ){
    $images = $_FILES["images"]["name"];
    $length = count($images);
    $upload = 0;
    $track  = "";
    if($d) echo " > $length Files ( ";
    foreach ($_FILES["images"]["name"] as $name => $file) {
      if ($_FILES["images"]["error"][$name] > 0){
        $alert = "Hochladen-Fehler"; //.$_FILES["images"]["error"];
        $track.= "E: ";
      }
      else
      if(($_FILES["images"]["type"][$name] != "image/jpg")
      && ($_FILES["images"]["type"][$name] != "image/jpeg")
      && ($_FILES["images"]["type"][$name] != "image/pjpeg")){
        $alert = "Bitte nur jpg Formate";
        $track.= "T: ";
      }
      else if ($_FILES["images"]["size"][$name] > 100000){
        $alert = "Bitte auf 100kb verkleinern";
        $track.= "S: ";
      }
      else{
        $track .= "OK: ";
        $upload ++;
        move_uploaded_file( $_FILES["images"]["tmp_name"][$name], "../images.cms/".$name.".jpg" );
      };
      $track .= $file." AS ".$name.", ";
    };
    $note = $upload." ".($upload==1 ? "Bild " : "Bilder ");
    if($d) echo $track.")";
    track("upload", $track);
  };

  // Contents

  if( isset($_POST["contents"]) ){
    $contents = $_POST["contents"];
    $length = count($contents);
    $titles = "";
    if($d) echo " > $length Contents ( ";
    foreach($contents as $title => $content){
      if($d) echo $title." ";
      $update = DB::update("contents", array( "content" => $content ), "title=%s", $title);
      $titles.= "$title,";
    } if($d) echo ")";
    $note .= $length." ".($length>1?"Einträge":"Eintrag")." neu";
    $track = track("content", $length.": ".$titles);
    if($d) echo " > ".($track ? "Log tracked" : "Log failed");
  }

  /**
   ** Templating
   **/

  // RainTPL Engine
  include "raintlp/inc/rain.tpl.class.php"; //include Rain TPL
  raintpl::$tpl_dir = "../index.tmpl/"; // template directory
  raintpl::$cache_dir = "../index.cache/"; // cache directory
  raintpl::$path_replace = false; // raintpl::$base_url = "http://www.med-gutachten.at";

  $tpl = new RainTPL;

  // Caching
  //$head = $tpl->cache( "head-cms", $expire_time = 600, $cache_id=3 );
  //$body = $tpl->cache( "body", $expire_time = 600, $cache_id=4 );
  //if( !($head && $body) ){

    // Assignments
    $tpl->assign( "cms", true );      // we are here in the cms
    $tpl->assign( "admin", $admin );  // if logged in

    $tpl->assign( "user", $user );    // user name
    $tpl->assign( "alert", $alert );  // important note
    $tpl->assign( "note", $note );    // note
    $tpl->assign( "date", date("His") );  // cache

    // Content assign
    $contents_raw = DB::query("SELECT title, content FROM contents WHERE site=%s", $site);
    $contents = array();
    foreach ($contents_raw as $content) {
      $title = $content["title"];
      $contents[$title] = $content["content"];
    };
    if(false) print_r($contents);
    $tpl->assign( "content", $contents );

    // Draw
    $head = $tpl->draw( "head-cms", $return_string = true );
    $body = $tpl->draw( "body", $return_string = true );
  //};
?>

  <?php echo $head; ?>

  <?php echo $body; ?>

  </body>
</html>

<?php
// all Users
// $users = DB::query("SELECT user, lastlogin, lastip FROM users");
// foreach ($users as $user) {
//   echo "Name: " . $user["name"] . "<br />";
// };
?>
