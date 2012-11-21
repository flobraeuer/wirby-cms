<?php if(!class_exists('raintpl')){exit;}?><h1 data-wirby="single order-h1">Online Bestellsystem</h1>
<p data-wirby="multi order-p">Wir freuen uns Sie als Kunde begrüßen zu dürfen. Stellen Sie direkt eine Anfrage an uns: Obst und Gemüse suchen, Menge eintragen, Kontaktdaten ausfüllen und abschicken. Im Anschluss wird alles automatisch in unserem Büro ausgedruckt und wir können Ihnen so bald als möglich eine Rückmeldung geben.</p>

<div class="row-fluid">
<?php if( $is_admin ){ ?><?php }else{ ?><form class="form" method="post"><?php } ?>

  <div class="span5">
    <h2>Sobald Sie fertig sind</h2>
    <span id="submit-order" class="btn btn-danger">Bestellung abschicken</span>

    <h2>Kundendaten</h2>
    <label class="radio inline">
      <input type="radio" name="gender" value="Frau"> Frau</label>
    <label class="radio inline">
      <input type="radio" name="gender" value="Herr"> Herr</label><br>
    <input type="text" id="name" placeholder="Name"><br>
    <input type="text" id="customer" placeholder="Firma">

    <label for="number">Kontakt</label>
    <input type="text" id="number" placeholder="Telefonnummer"><br>
    <input type="text" id="email" placeholder="Emailadresse">

    <label for="street">Adresse</label>
    <input type="text" id="street" placeholder="Straße Hausnummer"><br>
    <input type="text" id="code" class="input-mini" placeholder="PLZ">
    <input type="text" id="town" class="input-middle" placeholder="Ort">

    <label class="checkbox">
      <input type="checkbox"> Den AGB zustimmen</label>
  </div>

  <div class="span7">
    <h2>Ausgewählte Produkte</h2>
    <div class="well">
      <p id="order-info" class="alert alert-error">Sie haben unterhalb noch keine Produkte ausgewählt. Ihre Bestellung könnte so aussehen:</p>

      
      <script id="add_item" type="text/html">
        <li {{#demo}}class="demo"{{/demo}} {{#id}}id="{{id}}"{{/id}}>
          <div class="input-append pull-right">
            <input class="input-mini" type="text" name="menge" value="{{menge}}">
            <span class="add-on">{{verpackung}}</span>
          </div>
          <input type="hidden" name="verpackung" value="{{verpackung}}">
          <input type="text" name="artikel" value="{{artikel}}" class="input-unstyled input-medium" disabled>
        </li>
      </script>
      

      <ul id="order-items" class="unstyled">

      </ul>
    </div>
  </div>

<?php if( $is_admin ){ ?><?php }else{ ?></form><?php } ?>

</div>

<div class="row-fluid">
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
</div>

<!--
<table id="articles" class="table-bordered ">
  <thead>
    <tr>
      <th>Artikel</th>
      <th>Kategorien</th>
      <th>Verpackung</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Ananas Extra Sweet</td>
      <td>Obst</td>
      <td>Stk</td>
    </tr>
    <tr>
      <td>Apfel Golden Delicious</td>
      <td>Obst</td>
      <td>kg</td>
    </tr>
    <tr>
      <td>Apfel Granny Smith</td>
      <td>Obst</td>
      <td>kg</td>
    </tr>
  </tbody>
</table>
-->
