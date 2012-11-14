<?php if(!class_exists('raintpl')){exit;}?><!--
<div id="wirbybar" role="navigation">
  <div class="quicklinks">
  	<ul class="ab-top-menu">
      <li id="wirbybar-logo"><a class="ab-item" href="/" title="Modus verlassen">Bearbeitungs-Modus</a></li>
      <li id="wirbybar-updates">
        <a class="ab-item" href="#" title="Anzahl der veränderten Inhalte">
          <span class="ab-icon"></span><span class="ab-label" id="wirby-count">Editoren laden</span></a>   </li>
      <li id="wirbybar-text">
        <span>Bitte klicken Sie nun einfach auf Elemente, die Sie bearbeiten möchten.</span>
      </li>
    </ul>
    <ul class="ab-top-secondary ab-top-menu">
      <li id="wirbybar-account" class="menupop">
        <a class="ab-item" href="#">
          <?php if( c::get('user') ){ ?>

            Hallo, {c::get('username')}
          <?php }else{ ?>

            Anmelden
          <?php } ?>

        </a>
        <div class="ab-sub-wrapper">
          <ul id="wp-admin-bar-user-actions" class=" ab-submenu">
            <?php if( c::get('user') ){ ?>

              <form method="post" accept-charset="utf-8">
                <label for="password">Passwort</label>
                <input type="password" name="password" id="password"/>
                <input type="submit" value="Passwort ändern" class="submit">
              </form>
            <?php }else{ ?>

              <form id="cms-login" method="post" accept-charset="utf-8">
                <input type="text" name="user" value="Benutzer" />
                <input type="password" name="password" value="   "/>
                <input type="submit" value="Login" class="submit" />
              </form>
            <?php } ?>

            <li id="wirbybar-logout"><a class="ab-item"  href="?logout">Sitzung beenden</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
-->

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <a class="brand" href="#">Bearbeitungsmodus</a>
    <ul class="nav">
      <li><a href="#"><i class="icon-refresh"></i> Editoren laden</a></li>
      <li><a>Bitte klicken Sie nun einfach auf Elemente, die Sie bearbeiten möchten.</a></li>
    </ul>
    <form class="navbar-form pull-right">
      <input type="text" class="span2" placeholder="Benutzer">
      <input type="text" class="span2" placeholder="Passwort">
      <button type="submit" class="btn">Anmelden</button>
    </form>
    <ul class="nav pull-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Hallo, Flo Bräuer <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#"><i class="icon-lock"></i> Abmelden</a></li>
          <li>Abmelden</li>
        </ul>
      </li>
    </ul>
  </li>
    </ul>
  </div>
</div>
