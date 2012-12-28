<?php if(!class_exists('raintpl')){exit;}?><div class="row-fluid" id="step2">
<?php if( $is_admin ){ ?><?php }else{ ?><form class="form" method="post"><?php } ?>


  <div class="span5">
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
      <script id="add_input" type="text/html">
        <div class="input-append">
          <input class="input-minii" type="text">
          <div class="btn-group">
            <button class="btn dropdown-toggle" data-toggle="dropdown">
              <span>{{verpackung}}</span>
              <i class="caret"></i>
            </button>
            <ul class="dropdown-menu">
              <li><a href="#" onclick="order_dropdown(this); return false;">kg</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Stk</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Tassen</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Kisten</a></li>
            </ul>
          </div>
        </div>
      </script>
      

      <ul id="order-items" class="unstyled">

      </ul>
    </div>
  </div>

  <div class="clearfix center">
    <div id="step2-back-btn" class="btn">Zurück</div>
    <div id="step2-btn" class="btn btn-large btn-danger">Bestellung verbindlich abschicken</div>
  </div>

<?php if( $is_admin ){ ?><?php }else{ ?></form><?php } ?>

</div>
