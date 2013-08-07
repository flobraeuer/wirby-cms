<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
  <head>
    <meta charset="utf-8" http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Pastolore - Der Pizza und Pasta Lieferant Wiens</title>

    <?= wirby::head(); ?>
    <?= wirby::load('head'); ?>
  </head>
  <body>
    <div id="topline">
      <div></div>
    </div>
    <header>
      <div class="container">
        <img src="<?= w::asset('img/pastolore.png') ?>" width="40%" ?>

        <nav>
          <ul>
            <li><?= w::a("Unser Angebot",   w::to(""), w::is("start")) ?></li>
            <li><?= w::a("Online Speisekarte",   w::to("order"), w::is("order")) ?></li>
            <li><?= w::a("Kontakt",   w::to("contact"), w::is("contact")) ?></li>
          </ul>

        </nav>
      </div>
    </header>

    <div class="main-body">
      <? if(w::page()): ?>
        <?= w::load(w::page()) ?>
      <? else: ?>
        <div class="tab-pane" id="start"><?= w::load(w::c("start")) ?></div>
      <? endif; ?>
    </div>

    <div class="container">
      <div class="row">
        <div class="span12">
          <img src="<?= w::asset('img/bg-main-gallery-line.png') ?>" alt="">
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="span7">
            <?= w::h2("footer-about-h", "center-responsive") ?>
            <img src="<?= w::asset('img/logos.png') ?>" alt="Mesh GmbH" width="100%" />
            <?= w::p("footer-about-p") ?>
            <p style="text-align: right; margin-top: 0;">
              <? if( w::page() != "contact" ): ?>
                <a href="<?= w::to('contact') ?>" class="button button-small">
                  <span class="button-text">Mehr Infos</span>
                </a>
              <? endif; ?>
            </p>
          </div>
          <div class="span5">
            <?= w::h2("footer-test-h", "center-responsive") ?>

            <div class="comment-author">
              <img src="<?= w::asset('img/women1.png') ?>" alt="">
              <?= w::p("footer-test-date", "date") ?>
              <?= w::p("footer-test-from", "author") ?>
            </div>
            <div class="comment-content">
              <?= w::p("footer-test-body") ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="span12 copyrights">
            <div class="brand">Pastolore</div>
            <?= w::p("footer-copy", "hidden-phone") ?>
            <a class="fb" href="#"></a>
          </div>
          <p class="visible-phone" style="text-align: center;">&copy; Ihrem Genuss verpflichtet.</p>
        </div>
      </div>
    </footer>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script src="<?= w::asset('js/bootstrap.min.js') ?>"></script>
    <script src="<?= w::asset('js/lightbox.js') ?>"></script>
    <script src="<?= w::asset('js/script.js') ?>"></script>

    <? wirby::body(); ?>

  </body>
</html>
