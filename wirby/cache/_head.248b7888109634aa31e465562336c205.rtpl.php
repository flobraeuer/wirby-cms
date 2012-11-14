<?php if(!class_exists('raintpl')){exit;}?><meta name="generator" content="Wirby" />

<link rel="stylesheet" type="text/css" href="wirby/assets/bootstrap.min.css" />
<script type="text/javascript" src="wirby/assets/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo $assets_loader;?>"></script>
<script type="text/javascript" language="javascript">

  head.js( "<?php echo join('","',$assets_js); ?>" );

  <?php if( c::get('is_admin') ){ ?>

  head.js( "<?php echo join('","',$assets_admin); ?>" );
  <?php } ?>


  head.ready( function(){
    <?php echo $assets_callback;?>();

    <?php if( c::get('is_admin') ){ ?>

    wirby = new Wirby();
    <?php } ?>

  });

</script>
