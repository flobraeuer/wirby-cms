<div class="container">
  <div class="row" <? if(! w::is_a()) echo 'id="step2"'; ?> >
  <? if(! w::is_a()){ ?><form class="form" method="post"><? } ?>

    <div class="span5">
      <?= w::h2("order-form-h") ?>

      <label class="radio inline"><?= w::input("radio", "gender-f", "", "name='gender'") ?>Frau</label>
      <label class="radio inline"><?= w::input("radio", "gender-m", "", "name='gender'") ?>Herr</label><br>
      <?= w::input("text", "name") ?><br>

      <?= w::label("number") ?>
      <?= w::input("text", "number") ?><br>
      <?= w::input("text", "email") ?>

      <?= w::label("street") ?>
      <?= w::input("text", "street") ?><br>
      <?= w::input("text", "code", "input-mini") ?>
      <?= w::input("text", "town", "input-middle") ?>

      <label class="checkbox"><?= w::input("checkbox", "accept-terms") ?>AGB akzeptieren</label>

    </div>

    <div class="span7">
      <?= w::h2("order-selected-articles-h") ?>
      <div class="well">
        <?= w::p("order-info", "alert alert-error") ?>

        <script id="add_item" type="text/html">
          <li {{#demo}}class="demo"{{/demo}} {{#id}}id="{{id}}"{{/id}}>
            <div class="input-append pull-right">
              <input class="input-minii" type="text" name="menge" value="{{menge}}" onchange="calculate_order()">
              <span class="add-on">{{verpackung}}</span>
            </div>
            <div class="input-append pull-right" style="margin-right: 10px">
              <input class="input-minii" type="text" name="preis" value="{{preis.replace('.',',')}}" data-preis="{{preis}}" disabled>
              <span class="add-on">€</span>
            </div>
            <input type="hidden" name="verpackung" value="{{verpackung}}">
            <input type="text" name="artikel" value="{{artikel}}" class="input-unstyled input-medium" disabled>
          </li>
        </script>

        <script id="add_input" type="text/html">
          <div class="input-append">
            <input class="input-minii" type="text">
            <div class="btn-group">
              <button class="btn">
                <span>{{verpackung}}</span>
              </button>
            </div>
          </div>
        </script>

        <ul id="order-items" class="unstyled">

        </ul>
      </div>
    </div>

    <div class="clearfix center">
      <?= w::button("step2-back-btn", "btn") ?>
      <?= w::button("step2-btn", "btn btn-large btn-danger", "data-loading-text='Bestellung wurde abgeschickt ...'") ?>
    </div>

  <? if(! w::is_a()){ ?></form><? } ?>
  </div>
</div>
