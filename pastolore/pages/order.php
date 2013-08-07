<div class="container">
  <div class="row">
    <div class="span12">
      <?= w::h2("order-h2"); ?>
      <?= w::p("order-p"); ?>
    </div>
  </div>
</div>

<div class="container" id="step1">
  <div class="row">
    <div class="span12">
      <?= w::h2("order-h2-categories"); ?>
      <div class="dataTableFilters">
        <?= w::div("order-categories"); ?>
      </div>
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
</div>

<? w::load("order2") ?>
