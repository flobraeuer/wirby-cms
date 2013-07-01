<?= w::h1("order-h1"); ?>
<?= w::p("order-p"); ?> <!--Wir freuen uns Sie als Kunde begrüßen zu dürfen. Stellen Sie direkt eine Anfrage an uns: Obst und Gemüse suchen, Menge eintragen, Kontaktdaten ausfüllen und abschicken. Im Anschluss wird alles automatisch in unserem Büro ausgedruckt und wir können Ihnen so bald als möglich eine Rückmeldung geben.-->

<div class="row-fluid" id="step1">
  <div class="span12">
    <?= w::h2("order-h2"); ?>

    <? if(w::is_a()){ ?>
      <script type="text/javascript">
        window.no_dataTable = true;
      </script>
    <? } ?>

    <div class="dataTable">
      <?= w::div("order-articles"); ?>
    </div>
  </div>

  <div class="clearfix center">
    <?= w::button("step1-btn", "btn btn-large btn-danger", "", "id='step1-btn'") ?>
  </div>

</div>

<? w::load("order2") ?>
