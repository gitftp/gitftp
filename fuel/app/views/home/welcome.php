<section class="big-hero section background-wrapper fullscreen with-overlay black-overlay active-section" style="height: 567px;">
    <div class="background-image parallax-background" data-stellar-background-ratio="0.5" style="background: url('<?php echo Asset::get_file('home.jpg', 'img') ?>') 0% 0%;">
    </div>
    <div class="container middle-content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="element text-center anim" style="color: white">
                    <?php // echo Asset::img('logow.png'); ?>
                    <p class="b " style="font-size: 40px;">
                        Git-ftp deployment made simple.
                    </p>
                    <p class="uppercase-text letter-spacing b" style="font-size: 20px;">
                        Deploy to multiple servers from branches.
                    </p>
                    <div class="space"></div>
                    <p>
                        <?php if(\Auth::instance()->check()){ ?>
                            <a href="<?php echo dash_url; ?>" class="btn btn-punch btn-info btn-md btn-darker" role="button">Goto Dashboard</a>
                        <?php }else{ ?>
                            <a href="<?php echo home_url . 'login'; ?>" class="btn btn-punch btn-info btn-md btn-darker" role="button">Try it for FREE</a>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--    <a href="#about" title="" class="scroll-down"><i class="fa animated infinite bounce ti-arrow-down"></i></a>-->
</section>

<section class="section active-section small-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h3 class="lighter uppercase-text b">Perfect for your project</h3>

                <p class="lead">You code, we deploy. Simple.</p>

                <div class="space hidden-sm hidden-xs"></div>
            </div>
            <div class="col-md-4">
                <div class="service-block">
                    <i class="fa fa-life-bouy text-primary"></i>
                    <h4 class="lighter">Time saver</h4>

                    <p class="big-text">Uploading vast number of files over and over again takes time. We tackle it by uploading only changes.</p>

                    <div class="space hidden-sm hidden-xs"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block">
                    <i class="icon ti-layers-alt text-primary"></i>
                    <h4 class="lighter">Environments</h4>

                    <p class="big-text">Deploy git branches to multiple servers, create environments for development, production, so on.</p>

                    <div class="space hidden-sm hidden-xs"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block">
                    <i class="fa fa-rocket text-primary"></i>
                    <h4 class="lighter">Flexibility</h4>

                    <p class="big-text">
                        Get control over deployments. Sync, Push, Revert to revisions. directly on the server.
                    </p>
                </div>
            </div>
            <div class="col-md-12"></div>
            <div class="col-md-4">
                <div class="service-block">
                    <i class="fa fa-dashboard text-primary"></i>
                    <h4 class="lighter">Realtime monitoring</h4>
                    <p class="big-text">
                        Look what deployments are currently active for respective environments.
                    </p>
                    <div class="space hidden-sm hidden-xs"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block">
                    <i class="fa fa-leaf text-primary"></i>
                    <h4 class="lighter">Environments</h4>

                    <p class="big-text">Deploy git branches to multiple servers, create environments for development, production, so on.</p>

                    <div class="space hidden-sm hidden-xs"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block">
                    <i class="fa fa-rocket text-primary"></i>
                    <h4 class="lighter">Flexibility</h4>

                    <p class="big-text">
                        Get control over deployments. Sync, Push, Revert to revisions. directly on the server.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section content-col-3 active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 editContent">
                <h4>Material Design</h4>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex.</p>
            </div>
            <div class="col-md-4 editContent">
                <h4>Frontend Page Builder</h4>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex.</p>
            </div>
            <div class="col-md-4 editContent">
                <h4>Easy to Use</h4>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex.</p>
            </div>
        </div>
    </div>
</section>

<section class="section big-padding grey-background active-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2 class="lighter">Introducing <strong>Material</strong></h2>

                <p class="lead">Sed ut perspiciatis unde omnis iste eillo inventore.</p>
                <h5>What is <strong>Google Material Design</strong></h5>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex.</p>

                <p><a href="#" title="" class="btn btn-punch btn-link btn-black">Learn More</a>
                    <a href="#" title="" class="btn btn-punch btn-link btn-black">Watch Video</a></p>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/Q8TXgCzxEnw" frameborder="0" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section background-wrapper big-padding with-overlay info-overlay active-section">
    <div class="background-image" style="background: url(demo/hero/big1.jpg) 50% 0%;">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2 class="lighter">
                    <strong>Material</strong> is an internationally renowned creative agency that makes kick ass branding, design &amp; film.
                </h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex.</p>

                <p><a href="#" class="btn btn-punch btn-link btn-white">What We Do</a>
                    <a href="#" class="btn btn-punch btn-link btn-white">Get In Touch</a></p>
            </div>
        </div>
    </div>
</section>