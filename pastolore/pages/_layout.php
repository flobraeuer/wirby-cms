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
            <li class='<?= w::is("start")   ?>'><?= w::a("Willkommen",    w::to("")) ?></li>
            <li class='<?= w::is("news")   ?>'><?= w::a("Unser Angebot",    w::to(""), "active") ?></li>
            <li class='<?= w::is("order")   ?>'><?= w::a("Online Speisekarte",   w::to("order")) ?></li>
            <li class='<?= w::is("contact") ?>'><?= w::a("Kontakt",   w::to("contact")) ?></li>
          </ul>

        </nav>
      </div>
    </header>
    <div id="carousel" class="carousel slide">
      <div class="container">
        <div class="carousel-inner">
          <div class="active item">
            <img src="<?= w::asset('img/carousel1.jpg') ?>">
            <div class="hidden-phone">
              Wir liefern richtig gute Pizza und Pasta!
              <span></span>
            </div>
          </div>
          <div class="item">
            <img src="<?= w::asset('img/carousel2.jpg') ?>">
            <div class="hidden-phone">
              Probieren Sie es gleich heute aus!
              <span></span>
            </div>
          </div>
        </div>
        <a class="carousel-control left" href="#carousel" data-slide="prev"><img src="<?= w::asset('img/carousel-arrow-left.png') ?>" alt=""></a>
        <a class="carousel-control right" href="#carousel" data-slide="next"><img src="<?= w::asset('img/carousel-arrow-right.png') ?>" alt=""></a>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="span3 box center-responsive">
          <h2>Qualitätsanspruch</h2>
          <img src="<?= w::asset('img/box1.jpg') ?>" alt="">
          <p>Für Pastolore zählt nur eines: Kundenzufriedenheit! Wir freuen uns über Lob und Kritik um uns zu verbessern!</p>
          <a href="<?= w::to("contact") ?>" class="button-color">
            <span class="button-icon"><img src="<?= w::asset('img/icon/mail.png') ?>" alt=""></span>
            <span class="button-text">Kontakt</span>
          </a>
        </div>
        <div class="span3 box center-responsive">
          <h2>Günstige Lieferkosten</h2>
          <img src="<?= w::asset('img/box2.jpg') ?>" alt="">
          <p>Wir liefern frei Haus. Wenn Sie bis 31.7. online bestellen, erlassen wir Ihnen die Hälfte der Liefergebühren. Ohne Mindestbestellwert!</p>
          <a href="#" class="button">
            <span class="button-icon"><img src="<?= w::asset('img/icon/truck.png') ?>" alt=""></span>
            <span class="button-text">Bestellung</span>
          </a>
        </div>
        <div class="span6">
          <div class="board hidden-phone">
            <div class="board-inner">
              <div class="item active">
                <br>
                <p><strong>Menü der Woche</strong></p>
                <br>
                <ul>
                  <li>
                    <span class="left">Margerita</span>
                    <span class="right">5 €</span><br>
                  </li>
                  <li>
                    <span class="left">Cola / Fanta</span>
                    <span class="right">2 €</span>
                  </li>
                  <li>
                    <span class="left">Nachspeise</span>
                    <span class="right">2 €</span>
                  </li>
                </ul>
                <p style="text-align: center;">gesamt 9 €</p>
              </div>
              <div class="item">
                <br>
                <p><strong>Angebot des Monats</strong></p>
                <br>
                <ul>
                  <li>
                    <span class="left">- Salami Pizza</span>
                    <span class="right">7 €</span>
                  </li>
                  <li>
                    <span class="left">- Frutti di Mare</span>
                    <span class="right">9 €</span>
                  </li>
                  <li>
                    <span class="left">- Hot Pepperoni</span>
                    <span class="right">2 €</span>
                  </li>
                </ul>
              </div>
            </div>
            <ul class="board-nav">
              <li class="active"><span></span></li>
              <li><span></span></li>
            </ul>
          </div>
        </div>
      </div>
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
            <h2 class="center-responsive">Wer steht hinter Pastolore?</h2>
            <img src="<?= w::asset('img/logos.png') ?>" alt="Mesh GmbH" width="100%" />
            <p>Die MESH GmbH ist eine fixe Gr&ouml;&szlig;e in der Wiener Gastro Szene.<br>
              Sie können auf gute Qualität und hervoragenden Service vertrauen.<br>
              "Bestellen mit Vertrauen" ist unser Motto.</p>
            <p style="text-align: right; margin-top: 0;">
              <a href="#" class="button button-small">
                <span class="button-text">Mehr Infos</span>
              </a>
            </p>
          </div>
          <div class="span5">
            <h2 class="center-responsive">Erfahrungsbericht</h2>
            <div class="comment-author">
              <img src="<?= w::asset('img/women1.png') ?>" alt="">
              <p class="date">3. Juli 2013</p>
              <p class="author">Julia Gutmann</p>
            </div>
            <div class="comment-content">
              <p><strong>Ich muss zugeben, ich bestelle sehr oft Pizza, weil mir kochen einfach zu anstrengend ist am Feierabend</strong></p>
              <p>Pastolore hat mich total überzeugt. Super schnelle Lieferung. Gerne nocheinmal!</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="span12 copyrights">
            <div class="brand">Pastolore</div>
            <p class="hidden-phone">&copy; MESH GmbH 2013. Ihrem Genuss verpflichtet.</p>
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

  </body>
</html>
