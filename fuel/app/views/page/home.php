<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<?php echo Asset::css('home-main.css'); ?>
<?php echo Asset::js('home-main.js'); ?>

<div class="home-image">
    <?php echo View::forge('layout/nav'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="height: 40px;"></div>
                <div class="text-center">
                    <p style="color: #444">
                        <?php echo Asset::img('logo-w.png', array('class', 'logo-image')); ?><br>
                    <!-- <p style="font-size: 3em;font-weight: 100; text-transform: lowercase;">Push &amp; Deploy</p> -->
                    <p style="font-size: 3em;font-weight: 100; text-transform: lowercase;">GIT auto deployment. Simplified.</p>
                    <a href="<?php echo Uri::base(false) ?>signup" class="btn btn-default btn-lg">Taste the Power</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="home-tagline">
                    <p>
                        Push your changes to Github or Bitbucket, and deploy them on your Server.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-center">
					the three step magic.
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				1. Push changes
			</div>
			<div class="col-md-4">
				2. Detect changes
			</div>
			<div class="col-md-4">
				3. We deploy
			</div>
		</div>
	</div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>