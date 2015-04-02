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
                <div class="row">
                    <div class="col-md-10">
                        <iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3771.2731586329933!2d73.075665!3d19.051724!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c21b540d2559%3A0xb130e357f2d2d2ab!2sGlobal+Property+Kart!5e0!3m2!1sen!2sin!4v1423911260106"></iframe>
                        <div class="row">
                            <div class="col-md-8">
                                <h3 style="margin-bottom: 20px;">Contact</h3>
                                <p>Send us a message!</p>
                                <p><?php echo $msg; ?></p>
                                <form method="post">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Your name">
                                    </div>
                                    <div class="form-group">
                                        <label for="">E-mail</label>
                                        <input type="text" name="email" class="form-control" placeholder="Your E-mail">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Mobile no.</label>
                                        <input type="text" name="mobileno" class="form-control" placeholder="Your Mobile no.">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Message</label>
                                        <textarea name="msg" id="msg" cols="30" rows="5" class="form-control" style="resize: vertical"></textarea>
                                    </div>
                                    <button class="btn btn-warning pull-right">Send message</button>
                                </form>
                            </div>

                            <div class="col-md-4">
                                <div class="space20"></div>
                                <strong><em>Address: </em></strong> <br>
                                <strong>Office No :</strong> 47,Kesar Garden, <br>
                                Plot No-53, Sector-20, <br>
                                Kharghar,Navi Mumbai - 410210 <br>
                                <strong>Land line:</strong> 022 - 2774 2092 <br>
                                <strong>Mobile No: </strong>+91 9820 053 449
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="box"><img src="http://placehold.it/140x100&text=Advs"></div>
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


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>

<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/vendor/bootstrap.min.js"></script>
<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/main.js"></script>
</body>
</html>
