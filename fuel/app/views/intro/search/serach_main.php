<?php
echo View::forge('intro/search/header', array('seopagename' => $seopagename));
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
                            <a href="#" class="selected">Properties (<?php echo count($data); ?>)</a>
                            <!--                            <a href="#">Location Panvel (9)</a>
                                                        <a href="#">Budget 55 Lacs - 90 Lacs (88)</a>-->
                        </div>
                        <div class="clear"></div>
                        <?php
                        if (isset($data) && !empty($data)) {
                            foreach ($data as $key => $value) {
                                ?>
                                <a href="<?php echo Uri::base(false) . 'new/search/newdetails/' . $value['property_id']; ?>" class="listing">
                                    <div class="entry-container">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="details">
                                                    <span class="title"><strong><?php echo $value['property_name']; ?></strong>
                                                        <br><?php echo idconvert::get_pt_sub_title($value); ?> 
                                                        <span class="pull-right text-right">
                                                            <?php
                                                            echo idconvert::get_pt_rt_side_details($value);
                                                            ?>
                                                        </span> 
                                                    </span>
                                                    <div class="content">
                                                        <p><span class="content-title">location:</span><?php echo idconvert::get_property_location($value['location']); ?></p>
                                                        <p><span class="content-title">status:</span> 
                                                            <?php
                                                            echo idconvert::get_pt_status_details($value);
                                                            ?>
                                                        </p>
                                                        <?php
                                                        echo idconvert::get_pt_details($value);
                                                        ?>                                                            
                                                    </div>

                                                    <div class="button-left">
                                                        <a href="" class="btn btn-warning btn-sm btn-action-contact" data-propertyid="<?php echo $value['property_id'] ?>">Contact</a>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="image-container">

                                                    <div class="image" style="background-image: url('<?php echo idconvert::get_pt_img($value); ?>')" alt=""></div>
                                                    <!--<div class="image" style="background-image: url('http://dummyimage.com/200x200/858282/d4d5db.png&text=No+Image')" alt=""></div>-->
                                                    <div class="space10"></div>
                                                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                                        <!--                                                        <a href="" class="btn btn-default btn-sm">Report</a>-->
                                                        <a href="<?php echo Uri::base(false) . 'user/addcart/' . $value['property_id']; ?>" class="btn btn-default btn-sm btn-shortlist" data-property-id="<?php echo $value['property_id']; ?>">Shortlist</a>
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
                        <?php foreach (idconvert::get_postadv() as $key => $value) { ?>
                            <a href="http://<?php echo $value['link']; ?>">
                                <div class="box">
                                    <img src="<?php echo Uri::base(false) . 'assets/img/postadv/' . $value['image_name']; ?>"><?php echo $value['adv_desc']; ?>
                                </div>
                            </a>
                        <?php } ?>
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
