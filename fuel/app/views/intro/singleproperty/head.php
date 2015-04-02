<head>
    <meta charset="utf-8">
    <title>Akshar Evorra</title>
    <meta name="keywords" content="Akshar Evorra"/>
    <meta name="description" content="Akshar Evorra"/>
    <link href="<?php echo Uri::base(false) . 'spassets/'; ?>css/styleNew.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?php echo Uri::base(false) . 'spassets/'; ?>css/no-theme/jquery-ui-1.10.4.custom.html" rel="stylesheet">
    <link href="<?php echo Uri::base(false) . 'spassets/'; ?>css/colorbox.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo Uri::base(false) . 'spassets/'; ?>ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo Uri::base(false) . 'spassets/'; ?>js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo Uri::base(false) . 'spassets/'; ?>js/jquery.idTabs.min.js"></script>
    <script src="<?php echo Uri::base(false) . 'spassets/'; ?>js/scrollIt.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo Uri::base(false) . 'spassets/'; ?>js/jquery.colorbox-min.js"></script>
    <script src="<?php echo Uri::base(false) . 'spassets/'; ?>js/jquery-ui-1.10.4.custom.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Waiting+for+the+Sunrise|Engagement' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="<?php echo Uri::base(false) . 'spassets/'; ?>js/move-top.js"></script>
    <script type="text/javascript" src="<?php echo Uri::base(false) . 'spassets/'; ?>js/easing.js"></script>
    <script type="text/javascript" src="<?php echo Uri::base(false) . 'spassets/'; ?>js/coin-slider.min.js"></script>
    <link rel="stylesheet" href="<?php echo Uri::base(false) . 'spassets/' ?>css/coin-slider-styles.css" type="text/css"/>
    <script>var _comscore = _comscore || [];
        _comscore.push({c1: "2", c2: "6036484"});
        (function() {
            var s = document.createElement("script"), el = document.getElementsByTagName("script")[0];
            s.async = true;
            s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
            el.parentNode.insertBefore(s, el);
        })();</script>
    <noscript>
<img src="http://b.scorecardresearch.com/p?c1=2&amp;c2=6036484&amp;cv=2.0&amp;cj=1"/>
</noscript>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-492553-2']);
    _gaq.push(['_setDomainName', '.magicbricks.com']);
    _gaq.push(['_addIgnoredOrganic', 'magicbricks.com']);
    _gaq.push(['_addIgnoredOrganic', 'magicbricks']);
    _gaq.push(['_addIgnoredOrganic', 'magic brick']);
    _gaq.push(['_addIgnoredOrganic', 'magicbrick']);
    _gaq.push(['_addIgnoredOrganic', 'magic bricks']);
    _gaq.push(['_addIgnoredOrganic', 'http://www.magicbricks.com/']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

</script>
<script src="<?php echo Uri::base(false) . 'spassets/'; ?>js/jquery.fwd_tabs.js"></script>
<script type="text/javascript">
    $(function() {
        $(".tabs").fwd_tabs();
    });
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
        });

    });

</script>
<script>
    $(function() {
        $("#accordion").accordion();
    });

</script>
<script type="text/javascript">

    $(document).ready(function(e) {
//        $(function() {
//            setTimeout(function() {
//                jQuery.colorbox({open: true, fixed: true, href: 'form/popup-form.html', width: 772, height: 517});
//            }, 40000);
//        });

        $(".iframe").colorbox({iframe: true, width: "772px", height: "517px", fixed: true});
        $(".iframe1").colorbox({iframe: true, width: "70%", height: "90%", fixed: true});
        $(".youtube1").colorbox({iframe: true, innerWidth: 640, innerHeight: 390, fixed: true});
        $(".group1").colorbox({rel: 'group1'});
        $(".group2").colorbox({rel: 'group2', fixed: true});
        $(".group3").colorbox({rel: 'group3', fixed: true});
        $('.moreamenities').hide();
        $(function() {
            $("img.lazy").lazyload({
                effect: "fadeIn"
            });
        });
        $('.morespec').hide();
        $('.amenties-open').click(function() {
            $('.moreamenities').toggle();
        });
        $('.spec-open').click(function() {
            $('.morespec').toggle();
        });

        $("ul.thumb li a").click(function() {
            var mainImage = jQuery(this).attr("href");
            jQuery("#main_view img").attr({src: mainImage});
            jQuery("#main_view a").attr({href: mainImage});  // This is the line that isn't working!
            return false;
        });



    });

</script>
<script>
    $(document).ready(function() {

      

        $(document).ready(function() {
            $('#coin-slider').coinslider({width: 1366, height: 477, effect: 'straight', navigation: false, delay: 5000});
        });


        $.scrollIt({
            upKey: null, // key code to navigate to the next section
            downKey: null, // key code to navigate to the previous section
            easing: 'linear', // the easing function for animation
            scrollTime: 600, // how long (in ms) the animation takes
            activeClass: 'active', // class given to the active nav element
            onPageChange: null, // function(pageIndex) that is called when page is changed
            topOffset: 0 // offste (in px) for fixed top navigation
        });

    });
</script>
<script type="text/javascript">
    function handleResponse() {
        //alert(msghr);
        var msg = document.testform.ask.value;
        return msg;
    }
</script>
<script type="text/javascript">
    // Andy Langton's show/hide/mini-accordion - updated 23/11/2009
    // Latest version @ http://andylangton.co.uk/jquery-show-hide

    // this tells jquery to run the function below once the DOM is ready
    $(document).ready(function() {

        // choose text for the show/hide link - can contain HTML (e.g. an image)
        var showText = '...Read More';
        var hideText = '...Read Less';

        // initialise the visibility check
        var is_visible = false;

        // append show/hide links to the element directly preceding the element with a class of "toggle"
        $('.toggle').prev().append(' <a href="#" class="toggleLink">' + showText + '</a>');

        // hide all of the elements with a class of 'toggle'
        $('.toggle').hide();

        // capture clicks on the toggle links
        $('a.toggleLink').click(function() {

            // switch visibility
            is_visible = !is_visible;

            // change the link depending on whether the element is shown or hidden
            $(this).html((!is_visible) ? showText : hideText);

            // toggle the display - uncomment the next line for a basic "accordion" style
            //$('.toggle').hide();$('a.toggleLink').html(showText);
            $(this).parent().next('.toggle').toggle('slow');

            // return false so any link destination is not followed
            return false;

        });
    });

</script>
<script>
    $(document).ready(function() {

        $('.galleryTabButton li').click(function() {
            $('.galleryTabButton li').removeClass("highlight");
            $(this).addClass("highlight");
        });

    });
</script>
</head>