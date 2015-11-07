<section class="big-hero section background-wrapper fullscreen white-overlay active-section" style="height: 567px;">
    <div class="background-image background-move" data-stellar-background-ratio="0.5">
    </div>
    <div class="container middle-content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="element text-center home-page-title">
                    <?php echo Asset::img('logo.png'); ?>
                    <p class="tag">
                        Automatically deploy files from Git to Ftp. <br/>
                        <small>
                            Hassle free project deploy tool.
                        </small>
                    </p>
                    <div class="space"></div>
                    <p>
                        <?php if (\Auth::instance()->check()) { ?>
                            <a href="<?php echo dash_url; ?>" class="btn btn-punch btn-info btn-md btn-darker" role="button">Goto Dashboard</a>
                        <?php } else { ?>
                            <a href="<?php echo home_url . 'login'; ?>" class="btn btn-punch btn-info btn-md btn-darker" role="button">Try it for FREE</a>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--    <a href="#about" title="" class="scroll-down"><i class="fa animated infinite bounce ti-arrow-down"></i></a>-->
</section>

<section class="section background-wrapper small-padding with-overlay info-overlay active-section browser-container" style="overflow: initial">
    <div class="background-image" style="background: url('<?php echo Asset::get_file('home.jpg', 'img') ?>') 50% 0%;">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="browser text-center">
                    <?php
                    echo Asset::img('browser.png', array());
                    ?>

                    <div class="browser-screens">
                        <ul class="slides">
                            <li>
                                <?php echo Asset::img('generic/1-1.jpg', array()); ?>
                            </li>
                            <li>
                                <?php echo Asset::img('generic/2-1.jpg', array()); ?>
                            </li>
                            <li>
                                <?php echo Asset::img('generic/3-1.jpg', array()); ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<section class="section active-section small-padding text-center">
    <div class="works-with">
        <span>Works with</span> <?php echo Asset::img('generic/works-with.png'); ?>
    </div>
</section>
<section class="section active-section small-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h2 class="lighter b">Perfect for your Project!</h2>

                <p class="lead">You push, we deploy.</p>
            </div>
            <div class="col-md-3">
                <div class="paper text-center">
                    <span class="space"></span>
                    <i class="icon large fa fa-rocket red"></i>
                    <h4 class="b">Flexibility</h4>

                    <p class="lead">
                        Take control over your deployments. Deploy them automatically or manually.
                        Monitor your deployments in Realtime.
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="paper text-center">
                    <span class="space"></span>
                    <i class="icon large fa fa-leaf green"></i>
                    <h4 class="b">Environments</h4>

                    <p class="lead">
                        Create Workflow envionments to Deploy multiple Branches to multiple Servers.
                    </p>
                    <span class="space"></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="paper text-center">
                    <span class="space"></span>
                    <i class="icon large fa fa-server orange"></i>
                    <h4 class="b">Supports FTP/SSH</h4>

                    <p class="lead">
                        Easily deploy to any web server that support <br/>FTP, FTPS or SSH <br/>protocols.
                    </p>
                    <span class="space"></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="paper text-center">
                    <span class="space"></span>
                    <i class="icon large fa fa-lock blue"></i>
                    <h4 class="b">Security</h4>

                    <p class="lead">
                        Your Security is our priority. We use strong encryption for your user credentials & are only decryped when needed.
                    </p>
                    <span class="space"></span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section grey-background active-section try-it-for-free">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center clearfix">
                <h3 class="pull-left no-margin-bottom lighter b">Ready to boost your Workflow?</h3>
                <a href="<?php
                echo \Uri::create('signup');
                ?>" title="" class="btn btn-punch btn-success btn-lg btn-darker pull-right">Try it for free</a>
            </div>
        </div>
    </div>
</section>

