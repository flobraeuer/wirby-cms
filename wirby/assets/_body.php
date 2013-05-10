<script type="text/javascript" language="javascript">

  head.js( <?= "'".join("','",w::c("assets_js"))."'"; ?> );

  <? if(w::is_a()){ ?>
  head.js( <?= "'".join("','",w::c("assets_admin"))."'"; ?> );
  CKEDITOR.disableAutoInline = true;
  <? } ?>

  head.ready( function(){
    <?= w::c("assets_callback"); ?>();

    <? if(w::is_a()){ ?>
    wirby_ready();
    <? } ?>
  });
</script>

<? if(w::in_a()){ ?>

<div class="navbar navbar-fixed-bottom">
  <div class="navbar-inner">
    <a class="brand" href="#">Bearbeitungsmodus</a>
    <ul class="nav">
      <li><a href="#"><i class="icon-refresh"></i> <span id="wirby-editors">
        <?if(w::is_a()){?>startet ...<?}else{?>wartet ...<?}?></span></a></li>
      <li><a if="wirby-explain">
        <? if(w::c("has_error")) { ?>
          <?= w::c("has_error"); ?>
        <? } // Logged in
        elseif(w::is_a()) { ?> Sie können nun unterhalb Inhalte bearbeiten
        <? } // Log in
        else{ ?> Bitte melden Sie sich an:
        <? } ?>
      </a></li>
    </ul>

    <? if(w::is_a()) { ?>
    <ul class="nav pull-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Hallo, <?= w::c("admin", "name") ?> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#"><i class="icon-lock"></i> Passwort ändern</a></li>
          <li><a href="?type=logout"><i class="icon-home"></i> Abmelden</a></li>
        </ul>
      </li>
    </ul>

    <? } else { ?>
    <form class="navbar-form pull-right" method="post">
      <input name="user" type="text" class="span2" placeholder="Benutzer">
      <input name="pass" type="password" class="span2" placeholder="Passwort">
      <input name="type" type="hidden" value="login">
      <input name="edit" type="hidden" value="1">
      <button type="submit" class="btn"><i class="icon-lock"></i></button>
    </form>
    <? } ?>

  </div>
</div>

<? } else { ?>
  <a class="wirby" href="/admin"><i class="icon-wrench icon-white"></i></a>
<? } ?>
