<?php if(!class_exists('raintpl')){exit;}?><meta name="generator" content="Wirby" />

<link type="text/css" rel="stylesheet" href="wirby/assets/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="wirby/assets/datatable.bootstrap.css" />

<?php if( $in_wirby ){ ?>

<link type="text/css" rel="stylesheet" href="wirby/assets/style.css" />
<script type="text/javascript" src="wirby/libs/ckeditor/ckeditor.js"></script>
<?php } ?>


<script type="text/javascript" src="<?php echo $assets_loader;?>"></script>

<?php if( $google_analytics ){ ?>

  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo $google_analytics;?>']);
    _gaq.push(['_setDomainName', '<?php echo $domain;?>']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
<?php } ?>


<?php if( $google_plus ){ ?>

  <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
    {lang: 'de'}
  </script>
<?php } ?>


<?php if( $microsoft_verification ){ ?>

  <meta name="msvalidate.01" content="3703F5612A984D5F37D1B6A043A76C59" />
<?php } ?>


