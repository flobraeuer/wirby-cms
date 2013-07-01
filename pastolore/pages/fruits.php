<?= w::h1("fruits-h1") ?>
<?= w::p("fruits-p") ?>

<ul class="thumbnails">
  <li class="span3">
    <div class="thumbnail">
      <?= w::img("fruits-1-img", "Kleiner Obst Korb") ?>
      <?= w::h4("fruits-1-name") ?>
      <?= w::p("fruits-1-details") ?>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail">
      <?= w::img("fruits-2-img", "Mittlerer Obst Korb") ?>
      <?= w::h4("fruits-2-name") ?>
      <?= w::p("fruits-2-details") ?>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail">
      <?= w::img("fruits-3-img", "Großer Obst Korb") ?>
      <?= w::h4("fruits-3-name") ?>
      <?= w::p("fruits-3-details") ?>
    </div>
  </li>
</ul>

<?= w::div("fruits-details") ?>
