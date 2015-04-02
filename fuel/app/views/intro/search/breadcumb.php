<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb breadcrumb-global">
                <?php
                $url_seg = Uri::segments();
                echo '<li><a href="' . Uri::base(false) . '">Home</a></li>';
                foreach ($url_seg as $key => $value) {
                    echo '<li><a href="#">' . $value . '</a></li>';
                }
                ?>
            </ol>
        </div>
    </div>
</div>