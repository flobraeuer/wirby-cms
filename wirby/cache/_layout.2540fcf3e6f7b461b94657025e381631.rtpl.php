<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>M&M Obst und Gemüse</title>

<?php echo _head(); ?>

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "_head" );?>


</head>
<body>
  <?php if( $is_admin ){ ?><form id="wirby-form" method="post" accept-charset="utf-8" enctype="multipart/form-data"><?php } ?>

  <?php echo _body(); ?>


  <noscript><div class="alert alert-error">Sie haben in ihrem Browser leider kein Javascript aktiviert. Es kann zu Anzeigeproblemen kommen!</div></noscript>

  <div class="container" id="container">

    <div class="row-fluid" id="header">
      <img id="logo" src="gemuese/assets/logo.png" />

      <p id="leap">
        Obst und Gemüse
        <span class="hidden-phone">täglich frisch</span>
        <span class="sub-leap">Familienbetrieb Celik seit 1996</span>
      </p>

      <ul id="tab-menu" class="horizontal">
        <li><a id="tab-offer" href="#offer">Angebote</a></li>
        <li><a id="tab-order" href="#order">Online Bestellung</a></li>
        <li><a id="tab-about" href="#about">Unternehmen</a></li>
        <li><a id="tab-where" href="#where">Kontakt</a></li>
      </ul>
    </div>

    <div class="row-fluid">
      <div id="content" class="span11 offset1">

        <div class="tab-content">
          <div class="tab-pane fade" id="offer"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "offer" );?></div>
          <div class="tab-pane fade" id="order"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "order" );?></div>
          <div class="tab-pane fade" id="about"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "about" );?></div>
          <div class="tab-pane fade" id="where"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "where" );?></div>
        </div>

      </div>
    </div>
  </div>

  <?php if( $is_admin ){ ?><input name="type" type="hidden" value="update"></form><?php } ?>

</body>
</html>
