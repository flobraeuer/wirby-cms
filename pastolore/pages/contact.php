
<div class="container">
  <div class="row">
    <div class="span9">
      <?= w::h2("contact-h2-form") ?>
      <form id="contact" method="post">
          <div class="controls controls-row">
              <input id="contact-name" name="name" type="text" class="span3" placeholder="Name">
              <input id="contact-email" name="email" type="email" class="span3" placeholder="Email Adresse">
              <input id="contact-number" name="number" type="text" class="span3" placeholder="Telefonnummer">
          </div>
          <div class="controls controls-row">
              <textarea id="contact-message" name="message" class="span6 pull-left" placeholder="Ihre Nachricht an das Mesh Team" rows="5"></textarea>
              <input id="contact-subject" name="subject" type="text" class="span3" placeholder="Betreff der Nachricht">
              <br><br><br>
              <button id="contact-btn" type="submit" class="span3 btn btn-danger input-medium">Absenden</button>
          </div>
      </form>
    </div>
    <div class="span3">
      <?= w::h2("contact-h2-info") ?>
      <?= w::p("contact-info") ?>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="span12">
      <div id="map"></div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="span4"><?= w::h2("contact-infos-1h") ?><?= w::div("contact-infos-1") ?></div>
    <div class="span4"><?= w::h2("contact-infos-2h") ?><?= w::div("contact-infos-2") ?></div>
    <div class="span4"><?= w::h2("contact-infos-3h") ?><?= w::div("contact-infos-3") ?></div>
  </div>
</div>
