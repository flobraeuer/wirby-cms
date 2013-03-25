<?php

/**
 * Domain mapping
 */

c::set("domains", array(
  "gemuese.test" => "gemuese"
));

/**
 * Routen
 */

c::set("routes", array(

  /* Gemüsehändler */

  "gemuese.de" => array(
    "aktuelle-angebote" => "news",
    "online-bestellung" => "order",
    "obst-korb"         => "fruits",
    "ueber-celik"       => "about",
    "kontakt"           => "contact",
    "impressum"         => "imprint"
  ),

  "gemuese.en" => array(
    "actual-offers"     => "news",
    "online-order"      => "order",
    "fruits-basket"     => "fruits",
    "about-celik"       => "about",
    "contact"           => "contact",
    "imprint"           => "imprint"
  )

));

?>
