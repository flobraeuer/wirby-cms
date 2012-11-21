<?php

/**
 * Wirby CMS
 */

function actions(){
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
