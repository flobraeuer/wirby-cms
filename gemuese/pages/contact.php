<?= w::h1("contact-h1") ?>
<?= w::p("contact-p") ?>
<div class="row-fluid">
  <div class="span9">
    <?= w::h2("contact-h2-form") ?>
    <form>
        <div class="controls controls-row">
            <input id="name" name="name" type="text" class="span3" placeholder="Name">
            <input id="mail" name="email" type="email" class="span3" placeholder="Email Adresse">
            <input id="number" name="number" type="text" class="span3" placeholder="Telefonnummer">
        </div>
        <div class="controls controls-row">
            <textarea id="message" name="message" class="span6 pull-left" placeholder="Ihre Nachricht an das Team von M&amp;M Celik" rows="5"></textarea>
            <input id="subject" name="subject" type="text" class="span3" placeholder="Betreff der Nachricht">
            <br><br><br>
            <button id="contact-submit" type="submit" class="span3 btn btn-danger input-medium">Absenden</button>
        </div>
    </form>
  </div>
  <div class="span3">
    <?= w::h2("contact-h2-info") ?>
    <?= w::p("contact-info") ?>
  </div>
</div>
<div id="map"></div>

<div class="row-fluid">
  <div class="span4"><?= w::h2("contact-infos-1h") ?><?= w::div("contact-infos-1") ?></div>
  <div class="span4"><?= w::h2("contact-infos-2h") ?><?= w::div("contact-infos-2") ?></div>
  <div class="span4"><?= w::h2("contact-infos-3h") ?><?= w::div("contact-infos-3") ?></div>
</div>
