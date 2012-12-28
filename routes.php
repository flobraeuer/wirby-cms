<?php

/**
 * Domain mapping
 */

c::set("domains", array(
  "gemuese.test" => "gemuese"
));

c::set("pages", array(
  "gemuese" => array(
    "ueber-celik" => "about",
    "aktuelle-angebote" => "offer",
    "online-bestellung" => "order",
    "kontakt" => "where"
  ),
  "gemuese.en" => array(
    "about-celik" => "about",
    "actual-offers" => "offer",
    "online-order" => "order",
    "contact" => "where"
  )
));

?>
