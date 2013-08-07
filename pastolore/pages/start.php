<div id="carousel" class="carousel slide">
  <div class="container">
    <div class="carousel-inner">
      <div class="active item">
        <img src="<?= w::asset('img/carousel1.jpg') ?>">
        <div class="hidden-phone">
          <?# w::div("start-slider-2", "hidden-phone") ?>
          WIR LIEFERN RICHTIG GUTE PIZZA UND PASTA!
          <span></span>
        </div>
      </div>
      <div class="item">
        <img src="<?= w::asset('img/carousel2.jpg') ?>">
        <div class="hidden-phone">
          PROBIEREN SIE ES GLEICH HEUTE AUS!
          <?# w::p("start-slider-2") ?>
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
      <?= w::h2("start-box1-h") ?>
      <img src="<?= w::asset('img/box1.jpg') ?>" alt="">
      <?= w::p("start-box1-p") ?>
      <a href="<?= w::to("contact") ?>" class="button-color">
        <span class="button-icon"><img src="<?= w::asset('img/icon/mail.png') ?>" alt=""></span>
        <span class="button-text">Kontakt</span>
      </a>
    </div>
    <div class="span3 box center-responsive">
      <?= w::h2("start-box2-h") ?>
      <img src="<?= w::asset('img/box2.jpg') ?>" alt="">
      <?= w::p("start-box2-p") ?>
      <a href="<?= w::to('order') ?>" class="button">
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
