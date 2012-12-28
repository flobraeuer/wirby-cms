<?php if(!class_exists('raintpl')){exit;}?><script type="text/javascript" language="javascript">

  head.js( "<?php echo join('","',$assets_js); ?>" );

  <?php if( $is_admin ){ ?>

  head.js( "<?php echo join('","',$assets_admin); ?>" );
  <?php } ?>


  head.ready( function(){
    <?php echo $assets_callback;?>();

    <?php if( $is_admin ){ ?>

    wirby_ready();
    <?php } ?>

  });
</script>

<?php if( $in_wirby ){ ?>


<div class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="#">Bearbeitungsmodus</a>
    <ul class="nav">
      <li><a href="#"><i class="icon-refresh"></i> <span id="wirby-editors">
        <?php if( $is_admin ){ ?>startet ...<?php }else{ ?>wartet ...<?php } ?></span></a></li>
      <li><a if="wirby-explain">
        <?php if( $has_error ){ ?><?php echo $has_error;?>

        <?php }elseif( $is_admin ){ ?> Bitte klicken Sie unterhalb einfach herum.
        <?php }else{ ?> Bitte melden Sie sich an:
        <?php } ?>

      </a></li>
    </ul>

    <?php if( $is_admin ){ ?>

    <ul class="nav pull-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Hallo, <?php echo $is_admin['name'];?> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#"><i class="icon-lock"></i> Passwort ändern</a></li>
          <li><a href="?type=logout"><i class="icon-home"></i> Abmelden</a></li>
        </ul>
      </li>
    </ul>

    <?php }else{ ?>

    <form class="navbar-form pull-right" method="post">
      <input name="user" type="text" class="span2" placeholder="Benutzer">
      <input name="pass" type="text" class="span2" placeholder="Passwort">
      <input name="type" type="hidden" value="login">
      <input name="edit" type="hidden" value="1">
      <button type="submit" class="btn"><i class="icon-lock"></i></button>
    </form>
    <?php } ?>


  </div>
</div>

<?php }else{ ?>

  <a href="/admin"><i id="wirby" class="icon-wrench"></i></a>
<?php } ?>

