<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default navbar-fixed-top dash-nav">
                <div class="container">
                    <div class="col-md-12">

                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a style="background-color: #f9f9f9" class="navbar-brand"
                               href="<?php echo home_url; ?>"> <?php echo Asset::img('logo-sm.png', array('style' => 'height: 40px; margin-top: -9px;')); ?> </a>
                            <!--<a class="navbar-brand" href="<?php //echo Uri::base(false); ?>"><i class="fa fa-git fa-fw"></i></a>-->
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-left drop">
                                <li class="home"><a href="<?php echo Uri::base(FALSE); ?>#/home"> <i
                                            class="fa fa-home"></i>&nbsp; Dashboard</a></li>
                                <li class="project"><a href="<?php echo Uri::base(FALSE); ?>#/project"><i
                                            class="fa fa-cloud"></i>&nbsp; Project</a></li>
                                <li class="ftp"><a href="<?php echo Uri::base(FALSE); ?>#/ftp"><i
                                            class="fa fa-server"></i>&nbsp; FTP servers</a></li>
                            </ul>


                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">Account</a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#"><i class="fa fa-fw"></i> Action</a></li>
                                        <li><a href="#"><i class="fa fa-fw"></i> Another action</a></li>
                                        <li><a href="#"><i class="fa fa-fw"></i> Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-wrench fa-fw"></i> Settings</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo Uri::base(FALSE); ?>user/logout"><i
                                                    class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#" onclick="Backbone.history.loadUrl(); return false;"
                                       data-toggle="tooltip" data-placement="left" title="Reload"><i
                                            class="fa fa-refresh fa-fw"></i></a></li>
                            </ul>

                        </div>
                        <!-- /.navbar-collapse -->

                    </div>
                </div>
                <!-- /.container-fluid -->
            </nav>
        </div>
    </div>
</div>
