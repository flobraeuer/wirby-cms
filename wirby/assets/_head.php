<meta name="generator" content="Wirby" />

<link type="text/css" rel="stylesheet" href="/wirby/libs/bootstrap/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="/wirby/libs/bootstrap/css/bootstrap-responsive.min.css" />
<link type="text/css" rel="stylesheet" href="/wirby/assets/datatable.bootstrap.css" />

<? if(w::in_a()) { ?>
  <script type="text/javascript" src="/wirby/libs/ckeditor/ckeditor.js"></script>

  <script src="/wirby/libs/fileuploader/client/js/header.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/util.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/button.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/ajax.requester.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/deletefile.ajax.requester.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/handler.base.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/window.receive.message.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/handler.form.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/handler.xhr.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/uploader.basic.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/dnd.js"></script>
  <script src="/wirby/libs/fileuploader/client/js/uploader.js"></script>

  <link type="text/css" rel="stylesheet" href="/wirby/assets/style.css" />
<? } ?>

<script type="text/javascript" src="<?= w::c('assets_loader') ?>"></script>

<? if(w::c("google_analytics")) { ?>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?= w::c("google_analytics") ?>']);
    _gaq.push(['_setDomainName', '<?= w::c("domain") ?>']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
<? } ?>

<? if(w::c("google_plus")) { ?>
  <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
    {lang: 'de'}
  </script>
<? } ?>

<? if(w::c("microsoft_verification")) { ?>
  <meta name="msvalidate.01" content='<?= w::c("microsoft_verification") ?>' />
<? } ?>

<style type="text/css">
  a.wirby { display: block; position: fixed; left: 5px; bottom: 5px; width: 20px; height: 20px; opacity: 0.0; }
  a.wirby:hover { opacity: 0.7; -webkit-transition: all 0.5s; -moz-transition: all 0.5s; transition: all 0.5s; }
</style>
