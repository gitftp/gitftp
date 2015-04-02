<!DOCTYPE html>
<html lang="en-US">
    <!--<![endif]-->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Globalpropertykart.com">
        <meta name="description" content = "Looking for Property? Buy, Sell & Rent property at Navi Mumbai - Navi Mumbai leading online real estate portal. Find Your Property around thousand of navi mumbai propertys." />
        <?php echo $headerscript; ?>   
        <title>Global Property Kart | Real Estate - Property - Navi-Mumbai Real Estate - Navi-Mumbai Properties - Sale - Buy - Rent Property - Online Property Site</title>
    </head>

    <body class="home page page-template">

        <?php echo $topheader; ?>
        <div id="content" class="clearfix">
            <div class="map-wrapper">
                <div class="map">
                    <!-- <div id="map" class="map-inner" style="height: 242px"></div> -->
                    <!-- /.map-inner -->
                    <!-- Property Filter Div-->
                    <div class="container">
                        <?php echo $propertyfilterform; ?>
                        <!-- /.row -->
                    </div>
                    <!-- /. Property Filter Div-->
                    <!-- /.container -->
                </div>
                <!-- /.map -->
            </div>

            <!-- /.map-wrapper -->
            <?php echo $contain; ?>
            <!-- /.container -->

        </div>
        <!-- /#content -->
        <div id="footer-wrapper">

            <?php echo $footertop; ?>
            <!-- /#footer-top -->
            <?php echo $footerbottom; ?>
        </div>
        <!-- /#footer-wrapper -->
        <?php echo $footerscript; ?>

    </body>
</html>
