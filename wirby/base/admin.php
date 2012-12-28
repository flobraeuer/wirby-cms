<?php

/**
 * Admin session
 */

function session(){
  $request = r::get("type", "");

  if( $request == "logout"){
    s::remove("user");
  }
  elseif( $request == "login" && r::is_post() ){
    $name = r::get("user","");
    $pass = r::get("pass","");

    if( strlen($name) && strlen($pass) ){
      $admin  =   db::select("users", array("name","user","lastip","lastlogin"), array("user"=>$name, "password"=>md5($pass)) );
      if($admin){ s::set("admin", $admin); }
      else{       c::set("has_error", "Benutzer und Passwort passen nicht zueinander."); }
    }
    else{ c::set("has_error", "Bitte gib einen Benutzernamen und ein Passwort ein."); }
  }

  if( r::get("admin") ){
    c::set("in_admin", true);
  }
  if( s::get("admin") ){
    c::set("in_admin", true);
    c::set("is_admin", s::get("admin") ? true : false);
  }
}

/**
 * Wirby CMS
 */

function admin(){
  $request = r::get("type","");

  if( $request == "update" && r::is_post() ){
    if( $contents = r::get("contents",false) ){

      $length = count($contents);
      $titles = "";
      foreach($contents as $title => $content){
        $existing = db::row( "contents", array("id"), array("title" => $title, "site" => c::get("site")) );
        if($existing){
          $update = db::update( "contents", array("content" => $content), array("id" => $existing["id"]) );
        }else{
          $insert = db::insert( "contents", array("content" => $content, "title" => $title, "site" => c::get("site")) );
        }
        $titles.= "$title,";
      }
      c::set("has_info", $length." ".($length>1?"Einträge":"Eintrag")." neu");
      //$track = track("content", $length.": ".$titles);
    }
  }
}

?>
