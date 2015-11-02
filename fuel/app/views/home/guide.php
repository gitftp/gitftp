<div class="section page-title small-padding active-section page-title-cp">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>HELP TOPICS</h1>
                <p class="">Professionally iterate efficient best practices and cooperative communities</p>
                <ol class="breadcrumb">
                    <li><a href="<?php
                        echo Uri::create('/');
                        ?>">Home</a></li>
                    <?php
                    $s = Uri::segments();
                    foreach ($s as $k => $s2) {
                        ?>
                        <li class="<?php echo count($s) - 1 == $k ? 'active' : '' ?>">
                            <?php if (count($s) - 1 != $k) { ?>
                                <a href="<?php
                                echo Uri::create($s2);
                                ?>"><?php echo strtolower($s2) ?></a>
                            <?php } else { ?>
                                <?php echo strtolower($s2); ?>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section blog-section active-section page-section-cp">
<div class="container">
<div class="row">
<div class="col-md-3">
    <div class="sidebar">
        <div class="widget">
            <h3 class="widget-title">Guide index</h3>
            <div class="list-group">
                <a href="#" class="list-group-item">Getting started</a>
                <a href="#" class="list-group-item">Installation</a>
                <a href="#" class="list-group-item">Adding a FTP server</a>
                <a href="#" class="list-group-item">Creating a Project</a>
                <a href="#" class="list-group-item">Adding Envionrments</a>
                <a href="#" class="list-group-item">What are WebHooks</a>
            </div>
        </div>
    </div>
</div>
<!--<div class="col-md-8 col-md-offset-1">-->
<div class="col-md-9">
    <div class="content">
        <div class="entry format-standard">
            <div class="entry-media">
                <a href="#" title=""><img src="demo/blog/blog1.jpg" alt="" class="img-responsive"></a>
            </div>
            <div class="entry-top">
                <h3 class="entry-title"><a href="#" title="">Image Post Only</a></h3>
                <ul class="entry-meta list-inline">
                    <li><a href="#" title="">Apr 1, 2015</a></li>
                    <li><a href="#" title="">1 comment</a></li>
                </ul>
            </div>
            <div class="entry-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non laoreet dui. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa.</p>
            </div>
            <div class="entry-bottom">
                <ul class="list-inline entry-meta">
                    <li>
                        <a href="#" title=""><img alt="Jane Doe" src="demo/team/team1.jpg" class="avatar avatar-30 photo" height="30" width="30"> John Doe</a>
                    </li>
                    <li class="pull-right hidden-xs hidden-md hidden-mobile"><a href="#" title="">Read More</a></li>
                </ul>
            </div>
        </div>
        <div class="entry format-standard">
            <div class="entry-media">

                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="https://player.vimeo.com/video/38796545" width="500" height="281" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
                </div>
            </div>
            <div class="entry-top">
                <h3 class="entry-title"><a href="#" title="">Video Post Only</a></h3>
                <ul class="entry-meta list-inline">
                    <li><a href="#" title="">Apr 1, 2015</a></li>
                    <li><a href="#" title="">1 comment</a></li>
                </ul>
            </div>
            <div class="entry-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non laoreet dui. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa.</p>
            </div>
            <div class="entry-bottom">
                <ul class="list-inline entry-meta">
                    <li>
                        <a href="#" title=""><img alt="Jane Doe" src="demo/team/team1.jpg" class="avatar avatar-30 photo" height="30" width="30"> John Doe</a>
                    </li>
                    <li class="pull-right hidden-xs hidden-md hidden-mobile"><a href="#" title="">Read More</a></li>
                </ul>
            </div>
        </div>
        <div class="entry format-standard">
            <div class="entry-media">
                <blockquote cite="http://example.com/facts">
                    <p>Curabitur iaculis, ligula facilisis volutpat suscipit, sapien felis tempor, consequat vitae velit. </p>
                </blockquote>
            </div>
            <div class="entry-top">
                <h3 class="entry-title"><a href="#" title="">Quote Post Only</a></h3>
                <ul class="entry-meta list-inline">
                    <li><a href="#" title="">Apr 1, 2015</a></li>
                    <li><a href="#" title="">1 comment</a></li>
                </ul>
            </div>
            <div class="entry-bottom">
                <ul class="list-inline entry-meta">
                    <li>
                        <a href="#" title=""><img alt="Jane Doe" src="demo/team/team1.jpg" class="avatar avatar-30 photo" height="30" width="30"> John Doe</a>
                    </li>
                    <li class="pull-right hidden-xs hidden-md hidden-mobile"><a href="#" title="">Read More</a></li>
                </ul>
            </div>
        </div>
        <div class="entry format-standard">
            <div class="entry-media">
                <div class="flexslider">
                    <ul class="slides">
                        <li class="flex-active-slide" style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block; z-index: 2;">
                            <img src="demo/blog/gallery1.jpg" alt="" class="img-responsive" draggable="false"></li>
                        <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;" class="">
                            <img src="demo/blog/gallery2.jpg" alt="" class="img-responsive" draggable="false"></li>
                        <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;" class="">
                            <img src="demo/blog/gallery3.jpg" alt="" class="img-responsive" draggable="false"></li>
                    </ul>
                    <ol class="flex-control-nav flex-control-paging">
                        <li><a class="flex-active">1</a></li>
                        <li><a class="">2</a></li>
                        <li><a class="">3</a></li>
                    </ol>
                </div>
            </div>
            <div class="entry-top">
                <h3 class="entry-title"><a href="#" title="">Post with Media Gallery</a></h3>
                <ul class="entry-meta list-inline">
                    <li><a href="#" title="">Apr 1, 2015</a></li>
                    <li><a href="#" title="">1 comment</a></li>
                </ul>
            </div>
            <div class="entry-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non laoreet dui. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa.</p>
            </div>
            <div class="entry-bottom">
                <ul class="list-inline entry-meta">
                    <li>
                        <a href="#" title=""><img alt="Jane Doe" src="demo/team/team1.jpg" class="avatar avatar-30 photo" height="30" width="30"> John Doe</a>
                    </li>
                    <li class="pull-right hidden-xs hidden-md hidden-mobile"><a href="#" title="">Read More</a></li>
                </ul>
            </div>
        </div>
        <div class="entry format-standard">
            <div class="entry-top">
                <h3 class="entry-title"><a href="#" title="">Post with Text Only</a></h3>
                <ul class="entry-meta list-inline">
                    <li><a href="#" title="">Apr 1, 2015</a></li>
                    <li><a href="#" title="">1 comment</a></li>
                </ul>
            </div>
            <div class="entry-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non laoreet dui. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa.</p>
            </div>
            <div class="entry-bottom">
                <ul class="list-inline entry-meta">
                    <li>
                        <a href="#" title=""><img alt="Jane Doe" src="demo/team/team1.jpg" class="avatar avatar-30 photo" height="30" width="30"> John Doe</a>
                    </li>
                    <li class="pull-right hidden-xs hidden-md hidden-mobile"><a href="#" title="">Read More</a></li>
                </ul>
            </div>
        </div>
        <nav>
            <ul class="pagination">
                <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
            </ul>
        </nav>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>