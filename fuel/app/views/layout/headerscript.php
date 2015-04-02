
<link rel="shortcut icon" href="assets/img/favicon.png" type="image/png">
<link rel='stylesheet' id='font-css'
      href='http://fonts.googleapis.com/css?family=Open+Sans%3A400%2C700%2C300&#038;subset=latin%2Clatin-ext&#038;ver=3.6'
      type='text/css' media='all'/>


<link rel='stylesheet' id='revolution-fullwidth' href='<?php echo Uri::base(false) ?>assets/css/libraries/rs-plugin/css/fullwidth.css' type='text/css' media='all'/>
<link rel='stylesheet' id='revolution-settings' href='<?php echo Uri::base(false) ?>assets/css/libraries/rs-plugin/css/settings.css' type='text/css' media='all'/>
<link rel='stylesheet' id='bootstrap-css' href='<?php echo Uri::base(false) ?>assets/css/libraries/bootstrap/css/bootstrap.min.css' type='text/css' media='all'/>
<link rel='stylesheet' id='bootstrap-responsive-css' href='<?php echo Uri::base(false) ?>assets/css/libraries/bootstrap/css/bootstrap-responsive.min.css' type='text/css' media='all'/>

<link rel='stylesheet' id='pictopro-normal-css' href='<?php echo Uri::base(false) ?>assets/css/icons/pictopro-normal/style.css' type='text/css' media='all'/>
<link rel='stylesheet' id='justvector-web-font-css' href='<?php echo Uri::base(false) ?>assets/css/icons/justvector-web-font/stylesheet.css' type='text/css' media='all'/>
<link rel='stylesheet' id='chosen-css' href='<?php echo Uri::base(false) ?>assets/css/libraries/chosen/chosen.css' type='text/css' media='all'/>

<link rel='stylesheet' id='aviators-css' href='<?php echo Uri::base(false) ?>assets/css/jquery.bxslider.css' type='text/css' media='all'/>
<link rel='stylesheet' id='properta-css' href='<?php echo Uri::base(false) ?>assets/css/properta.css' type='text/css' media='all'/>
<link rel='stylesheet' id='properta-css' href='<?php echo Uri::base(false) ?>assets/css/jquery-confirm.css' type='text/css' media='all'/>
<style>
	.jconfirm-bg{
		z-index: -1;
	}
</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo Uri::base(false) ?>assets/js/aviators-settings.js'></script>
<script type='text/javascript' src='<?php echo Uri::base(false) ?>assets/js/jquery-confirm.min.js'></script>
<script type='text/javascript' src='<?php echo Uri::base(false) ?>assets/css/libraries/chosen/chosen.jquery.min.js'></script>
<script type='text/javascript' src='<?php echo Uri::base(false) ?>assets/css/libraries/rs-plugin/js/jquery.themepunch.revolution.min.js'></script>
<script type='text/javascript' src='<?php echo Uri::base(false) ?>assets/css/libraries/rs-plugin/js/jquery.themepunch.plugins.min.js'></script>
<script> var base_url = '<?php echo Uri::base(false); ?>'; </script>


<script>
<?php if(Auth::check()){ ?>
	var user = {
		status: true
	}
<?php }else{ ?>
	var user = {
		status: false
	}
<?php } ?>
</script>