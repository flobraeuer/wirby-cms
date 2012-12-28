<?php if(!class_exists('raintpl')){exit;}?><h1 data-wirby="single order-h1">Online Bestellsystem</h1>
<p data-wirby="multi order-p">Wir freuen uns Sie als Kunde begrüßen zu dürfen. Stellen Sie direkt eine Anfrage an uns: Obst und Gemüse suchen, Menge eintragen, Kontaktdaten ausfüllen und abschicken. Im Anschluss wird alles automatisch in unserem Büro ausgedruckt und wir können Ihnen so bald als möglich eine Rückmeldung geben.</p>

<div class="row-fluid" id="step1">
  <div class="span12">
    <h2>Unsere interaktive Produktliste</h2>

    <?php if( $is_admin ){ ?>

      <script type="text/javascript">
        window.no_dataTable = true;
      </script>
    <?php } ?>

    <div data-wirby="editor order-articles">
      <?php echo $content["order-articles"];?>

    </div>
  </div>

  <div class="clearfix center">
    <div id="step1-btn" class="btn btn-large btn-danger">Weiter zu Bestellübersicht</div>
  </div>
</div>

<?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "order2" );?>

