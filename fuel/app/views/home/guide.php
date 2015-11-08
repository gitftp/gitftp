<div class="section page-title small-padding background-wrapper with-overlay black-overlay active-section page-title-cp">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Help topics</h1>
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
                                ?>"><?php echo str_ireplace('-', ' ', strtolower($s2)); ?></a>
                            <?php } else { ?>
                                <?php echo str_ireplace('-', ' ', strtolower($s2)); ?>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section active-section page-section-cp">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar" id="st" data-top="90" data-bottom="100">
                    <div class="widget">
                        <h3 class="widget-title">Getting started</h3>
                        <div class="list-group list-group-cp">
                            <?php foreach ($doc_list as $p) { ?>
                                <a href="<?php echo \Uri::create('docs/' . $p['slug']) ?>" class="list-group-item <?php echo $slug == $p['slug'] ? 'active-item' : '' ?>"><?php echo $p['title'] ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="content">
                    <div class="entry format-standard">
                        <?php if (count($page) == 0) { ?>
                            <div class="entry-content">
                                <div class="space20"></div>
                                <p class="text-center gray">
                                    <i class="fa fa-unlink fa-4x"></i>
                                </p>
                                <h4 class="text-center">
                                    404, Page not found
                                </h4>

                                <p class="text-center">
                                    Sorry this page is not available. <br/>
                                    maybe this page is removed or moved permanently.
                                </p>
                            </div>
                        <?php
                        } else {
                            $page = $page[0];
                            ?>
                            <div class="entry-media">
                                <!--                            --><?php //echo \Asset::img('base.jpg'); ?>
                            </div>
                            <div class="entry-top">
                                <h2 class="entry-title">
                                    <a href="<?php echo \Uri::create('docs/' . $page['slug']); ?>" title="<?php echo $page['title']; ?>"><?php echo $page['title']; ?></a>
                                </h2>
                            </div>
                            <div class="entry-content">
                                <?php echo $page['content']; ?>
                            </div>
                            <div class="entry-bottom">
                                <ul class="list-inline text-right article-helper">
                                    <li>Was this article helpful?</li>
                                    <li>
                                        <a class="green page-feedback" data-type="1" data-page-id="<?php echo $page['id'] ?>" href="#" title="">
                                            <i class="fa fa-thumbs-up"></i> Yes</a>
                                    </li>
                                    <li>
                                        <a class="orange page-feedback" data-type="0" data-page-id="<?php echo $page['id'] ?>" href="#" title="">
                                            <i class="fa fa-thumbs-down"></i> No</a>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>