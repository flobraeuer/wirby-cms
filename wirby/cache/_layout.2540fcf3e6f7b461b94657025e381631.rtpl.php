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
      <!--<img id="logo" src="gemuese/assets/logo.png" />-->

      <div id="leap">
        <p>Obst und Gemüse <span class="hidden-phone">täglich frisch</span></p>
        <a href="#about" data-toggle="tab">Familienbetrieb Celik seit 1996</a>
      </div>

      <ul id="tab-menu" class="horizontal">
        <li <?php echo _is('start', 'left'); ?>><a id="tab-start" href="/">M&amp;M Großhandel</a></li>
        <li <?php echo _is('offer'); ?>><a id="tab-offer" href="offer">Angebote</a></li>
        <li <?php echo _is('order'); ?>><a id="tab-order" href="order">Online Bestellung</a></li>
        <li <?php echo _is('about'); ?>><a id="tab-about" href="about">Unternehmen</a></li>
        <li <?php echo _is('where'); ?>><a id="tab-where" href="where">Kontakt</a></li>
      </ul>
    </div>

    <div class="row-fluid">
      <div id="content-border" class="span12">
        <div id="content">

          <?php if( $page ){ ?>

            <?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "".$page."" );?>

          <?php }else{ ?>

            <div class="tab-content">
              <div class="tab-pane" id="start"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "start" );?></div>
            </div>
          <?php } ?>


        </div>
      </div>
    </div>
  </div>

  <div id="raster"></div>
  <?php if( $is_admin ){ ?><input name="type" type="hidden" value="update"></form><?php } ?>

</body>
</html>
