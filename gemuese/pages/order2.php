<div class="row-fluid" <? if(! w::is_a()) echo 'id="step2"'; ?> >
<? if(! w::is_a()){ ?><form class="form" method="post"><? } ?>

  <div class="span5">
    <?= w::h2("order-form-h") ?>

    <?= w::label("gender-f", "radio inline", "", w::input("radio", "gender-f", "", "name='gender'")) ?>
    <?= w::label("gender-m", "radio inline", "", w::input("radio", "gender-m", "", "name='gender'")) ?>
    <?= w::input("text", "name") ?><br>
    <?= w::input("text", "customer") ?>

    <?= w::label("number") ?>
    <?= w::input("text", "number") ?><br>
    <?= w::input("text", "email") ?>

    <?= w::label("street") ?>
    <?= w::input("text", "street") ?><br>
    <?= w::input("text", "code", "input-mini") ?>
    <?= w::input("text", "town", "input-middle") ?>

    <?= w::label("accept-terms", "checkbox", "", w::input("checkbox", "accept-terms") ) ?>

  </div>

  <div class="span7">
    <?= w::h2("order-selected-articles-h") ?>
    <div class="well">
      <?= w::p("order-info", "alert alert-error") ?>

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
              <li><a href="#" onclick="order_dropdown(this); return false;">Kg</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Stk</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Tassen</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Kisten</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Bund</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Kolli</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Säcke</a></li>
              <li><a href="#" onclick="order_dropdown(this); return false;">Kübel</a></li>
            </ul>
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
