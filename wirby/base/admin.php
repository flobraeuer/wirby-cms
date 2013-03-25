<?php

/**
 * Admin session
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
 * Wirby CMS
 */

function admin(){
  $request = r::get("type", "");

  if( $request == "update" && r::is_post() ){
    if( $contents = r::get("contents",false) ){

      $count = count($contents);
      $updated = 0;
      $inserted = 0;
      $changed = array();
      foreach($contents as $title => $content){
        $existing = db::row( "contents_".c::get("site"), array("id"), array("title" => $title) );
        if($existing){
          $update = db::update( "contents_".c::get("site"), array("content" => $content), array("id" => $existing["id"]) );
          $updated ++;
        }else{
          $insert = db::insert( "contents_".c::get("site"), array("content" => $content, "title" => $title) );
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

?>
