<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>Dr. Michael Knotzer - Medizinische Gutachten</title>

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "_head" );?>

<?php echo _head(); ?>


</head>
<body>
  <?php echo _body(); ?>

  <div id="header">
    <div id="header-body">
      <a href="/" target="_self" title="Dr. Michael Knotzer" class="name">Dr. Michael</a>
      <a href="/" target="_self" title="Dr. Michael Knotzer" class="name big">Knotzer</a>
      <noscript>
        <div id="header-note" class="noscript">Sie haben in ihrem Browser leider kein Javascript aktiviert. Dadurch wird die Seite nicht optimal dargestellt. Schade.</div>
      </noscript>
    </div>
  </div>
  <div id="content">
    <?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "01.willkommen" );?>

  </div>
</body>
</html>
