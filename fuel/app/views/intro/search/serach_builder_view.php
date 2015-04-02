<?php
echo View::forge('intro/search/header');
echo View::forge('intro/search/breadcumb');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="search-block">
                <?php echo View::forge('intro/components/searchform'); ?>  
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-block">
                <div class="search-block-msg"><?php echo $search_view_msg; ?></div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="tabs">
                            <a href="#" class="selected">Builder(<?php echo count($data_count); ?>)</a>
                            <!--                            <a href="#">Location Panvel (9)</a>
                                                        <a href="#">Budget 55 Lacs - 90 Lacs (88)</a>-->
                        </div>
                        <div class="clear"></div>
                        <?php
                        if (isset($data_count) && !empty($data_count)) {
                            foreach ($data_count as $key => $value) {
                                ?>
                                <a href="#" class="listing">
                                    <div class="entry-container">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="details">
                                                    <span class="title"><strong><?php echo $value['builder_name']; ?></strong>
                                                        <br>
                                                        <span class="pull-right text-right">
                                                        </span> 
                                                    </span>
                                                    <div class="content">
                                                        <p><span class="content-title">Project in:</span>Ready Possession (<?php echo idconvert::get_count_property_builder($value['builder_id'],3); ?>)</p>
                                                        <p><span class="content-title">Project in:</span>Pre-Launch (<?php echo idconvert::get_count_property_builder($value['builder_id'],1); ?>)</p>
                                                        <p><span class="content-title">Project in:</span>Under Construction (<?php echo idconvert::get_count_property_builder($value['builder_id'],2); ?>)</p>
                                                        <p><span class="content-title">Project in:</span>Commerical (<?php echo idconvert::get_count_property_builder($value['builder_id'],4); ?>)</p>                                                          
                                                    </div>

                                                    <div class="button-left">
                                                        <a href="" class="btn btn-warning btn-sm btn-action-contact">Contact</a>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="image-container">

                                                    <div class="image" style="background-image: url('<?php echo Uri::base(false) . 'assets/img/builder_logo/' . $value['image_name']; ?>')" alt=""></div>
                                                    <!--<div class="image" style="background-image: url('http://dummyimage.com/200x200/858282/d4d5db.png&text=No+Image')" alt=""></div>-->
                                                    <div class="space10"></div>
                                                    <div class="btn-group btn-group-justified" role="group" aria-label="..."> 
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                        } else {
                            ?>
                            <a href="" class="listing">
                                <div class="entry-container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="details">
                                                <span class="title"><strong>Sorry No Property for your search.!!</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php }
                        ?>
                    </div>
                    <div class="col-md-2">
                        <div class="box"><img src="http://placehold.it/140x180&text=Advs">deasd aasdf<br>asdfsadfa</br></div>
                        <div class="box"><img src="http://placehold.it/140x100&text=Advs"></div>
                        <div class="box"><img src="http://placehold.it/140x100&text=Advs"></div>
                        <div class="box"><img src="http://placehold.it/140x100&text=Advs"></div>
                        <div class="box"><img src="http://placehold.it/140x100&text=Advs"></div>
                        <div class="box"><img src="http://placehold.it/140x100&text=Advs"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
echo View::forge('intro/search/footer');
?>  
</body>
</html>
