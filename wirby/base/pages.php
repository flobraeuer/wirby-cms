<?php
require_once "bottle-db.php";

/**
 * class to access the content (stored in a db)
 *
 * @package default
 * @author erich
 */
class ShipContent {

  private $contents_raw;
  private $contents;
  private $debug = false;

  function __construct($site) {
    // Content assign
    $this->contents_raw = DB::query("SELECT title, content FROM contents WHERE site=%s", $site);
    $this->contents = array();
    foreach ($this->contents_raw as $content) {
      $title = $content["title"];
      $this->contents[$title] = $content["content"];
    }
    if($this->debug) print_r($this->contents);
  }

  public function get($title) {
    if (array_key_exists($title, $this->contents)) {
      return $this->contents[$title];
    } else {
      return "sry, gibts noch nicht";
    }
  }

}

?>
