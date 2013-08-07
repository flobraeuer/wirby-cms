<?php

/**
 * Domain mapping
 */

c::set("domains", array(
  "gemuese.test" => "gemuese",
  "celik-obstgemuese.at" => "gemuese",
  "www.celik-obstgemuese.at" => "gemuese",
  "pastolore.test" => "pastolore",
  "pastolore.webarchitects.at" => "pastolore",
  "www.pastolore.webarchitects.at" => "pastolore"
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
    "impressum"         => "contact"
  ),

  "gemuese.en" => array(
    "actual-offers"     => "news",
    "online-order"      => "order",
    "fruits-basket"     => "fruits",
    "about-celik"       => "about",
    "contact"           => "contact",
    "imprint"           => "contact"
  ),

  "gemuese.es" => array(
    "noticias-ofertas"  => "news",
    "tienda-online"     => "order",
    "cesta-de-frutas"   => "fruits",
    "quienes-somos"     => "about",
    "contacto"          => "contact",
    "imprenta"          => "contact"
  ),

  "pastolore.de" => array(
    "online-bestellung" => "order",
    "kontakt"           => "contact"
  )

));

?>
