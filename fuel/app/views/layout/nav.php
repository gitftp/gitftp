<div style="height: 20px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo Uri::base(false); ?>"> <?php echo Asset::img('logo-sm.png', array('style' => 'height: 40px; margin-top: -9px;')); ?> </a>
                        <!--<a class="navbar-brand" href="<?php // echo Uri::base(false);  ?>"><i class="fa fa-git fa-fw"></i></a>-->
                        <!--<a class="navbar-brand" href="#">Gitploy</a>-->
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <!--                        <ul class="nav navbar-nav">
                                                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                                                    <li><a href="#">Link</a></li>
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Action</a></li>
                                                            <li><a href="#">Another action</a></li>
                                                            <li><a href="#">Something else here</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">Separated link</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">One more separated link</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>-->
                        <!--                        <ul class="nav navbar-nav navbar-left">
                                                    <li><a href="#">Link</a></li>
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Action</a></li>
                                                            <li><a href="#">Another action</a></li>
                                                            <li><a href="#">Something else here</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">Separated link</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>-->
                        <?php if (Auth::check()) { ?>

                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="<?php echo Uri::base(false); ?>dashboard"><i class="fa fa-home fa-fw"></i> Hola, <?php echo Auth::get_screen_name(); ?></a>
                                </li>
                                <li><a href="<?php echo dash_url ?>user/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                            </ul>

                        <?php } else { ?>

                            <form class="navbar-form navbar-right" method="POST" action="<?php echo Uri::base(false) ?>user/login" role="search">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="Email" value="">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="password" class="form-control" placeholder="Password" value="">
                                </div>
                                <button type="submit" class="btn btn-danger">Login</button>
                            </form>

                        <?php } ?>

                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
</div>
