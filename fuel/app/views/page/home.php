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

<div class="bg-gray deploy-process">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-center">
					deploy process.
				</h3>
			</div>
		</div>
		<div class="space20"></div>
		<div class="row">
			<div class="col-md-4">
				<div class="block">
					<p class="title">1. Make changes</p>
					<p>
						Automate deploys by pushing your changes to the git repository. We proceed with the rest.
					</p>
				</div>

			</div>
			<div class="col-md-4">
				<div class="block">
					<p class="title">2. Detect changes</p>
					<p>
						We investiate the add and modified files from your repository since last deployment, and stage them up for upload.
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="block">
					<p class="title">3. We deploy</p>
					<p>We make the changes on FTP servers and ensure everything is updated.</p>
				</div>
			</div>
		</div>
		<div class="space10"></div>
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