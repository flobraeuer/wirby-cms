<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>M&M Celik Obst und Gemüse</title>

<?= wirby::head(); ?>
<?= wirby::load('head'); ?>

</head>
<body class="<?= browser::css() ?> <?= "bg0".rand(1, 9) ?>" data-lang="<?= l::current() ?>">

  <? if(w::is_a()){ ?><form id="wirby-form" method="post" accept-charset="utf-8" enctype="multipart/form-data"><? } ?>
  <? wirby::body(); ?>

  <noscript><div class="alert alert-error">Sie haben in ihrem Browser leider kein Javascript aktiviert. Es kann zu Anzeigeproblemen kommen!</div></noscript>

  <div class="container" id="container">

    <div class="row-fluid" id="header">
      <!--<img id="logo" src="gemuese/assets/logo.png" />-->

      <div id="logo"><?= w::img("start-logo", "Familienbetrieb Celik", 100) ?></div>
      <div id="leap" class="leap">
        <div>
          <?= w::p("leap-text"); ?>
          <?= w::p("leap-hidden", "hidden-phone") ?>
        </div>
        <?= w::a("leap-sub", w::to("about")) ?>
      </div>

      <ul id="tab-menu" class="horizontal">
        <li class='<?= w::is("start")  ?> left'><?= w::a("tab-start", "/") ?></li>
        <li class='<?= w::is("news")   ?>'><?= w::a("tab-news",    w::to("news")) ?></li>
        <li class='<?= w::is("order")  ?>'><?= w::a("tab-order",   w::to("order")) ?></li>
        <li class='<?= w::is("fruits") ?>'><?= w::a("tab-fruits",  w::to("fruits")) ?></li>
        <li class='<?= w::is("about")  ?>'><?= w::a("tab-about",   w::to("about")) ?></li>
        <li class='<?= w::is("contact")?>'><?= w::a("tab-contact", w::to("contact")) ?></li>
      </ul>
    </div>

    <div class="row-fluid">
      <div id="content-border" class="span12">
        <div id="content" class="<?= w::page() ?>">

          <? if(w::page()): ?>
            <?= w::load(w::page()) ?>
          <? else: ?>
            <div class="tab-content">
              <div class="tab-pane" id="start"><?= w::load(w::c("start")) ?></div>
            </div>
          <? endif; ?>

        </div>
        <div id="actions">
          <div class="pull-left">
            <!--a href="http://www.facebook.com/pages/MM-Celik-Obst-und-Gem%C3%BCse/453488338033651"><i class="icon-share-alt icon-white"></i></a-->
            <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FMM-Celik-Obst-und-Gem%25C3%25BCse%2F453488338033651&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=false&amp;font=verdana&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=517712251593236" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>
          </div>
          <?= w::a("Deutsch", w::to_lang("de"), "first") ?>
          <?= w::a("English", w::to_lang("en")) ?>
          <?= w::a("Espa&ntilde;ol", w::to_lang("es")) ?>
          <!--i class="icon-info-sign icon-white"></i-->
          <?= w::a("tab-imprint", w::to("imprint"), "last") ?>
          <a href="http://www.webarchitects.at" class="last" target="_blank" data-toggle="tooltip" title="made with 'Wirby' and ♥ by Florian Bräuer" data-placement="left" title="Feedback?">♥</a>
        </div>
      </div>

    </div>
  </div>

  <? if(w::page()=="imprint" OR w::page()=="order"): ?>
    <?= w::load("terms") ?>
  <? endif; ?>

  <div id="raster"></div>
  <? if(w::is_a()){ ?><input name="type" type="hidden" value="update"></form><? } ?>
</body>
</html>
