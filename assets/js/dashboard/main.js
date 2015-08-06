window.app = {
    el: $('.bb-wrapper'),
    obj: {}
};

/*
 * Require JS starts here.
 */

require([
    "router",
    "process",
    "views/feedback",
], function (router, process, feedbackView) {

    if (!is_dash) {
        return false;
    }

    window.Router = new router.router();
    Backbone.history.on('all', function () {
        var h = location.hash;
        var l = h.substr(1);
        var j = l.split('/')[0] || l.split('/')[1];
        var k = h.split('/');

        $('.navbar-nav li').removeClass('active');
        $('.navbar-nav li.' + j).addClass('active');

        if (/deploy/ig.test(k[0])) {

            $subpage = $('.page-subview');
            try {
                var l = k[3];
            } catch (e) {
                var l = false;
            }
            $subpage.removeClass('active-cs');
            if (l) {
                $('.subview-' + l).addClass('active-cs');
            } else {
                $('.subview-activity').addClass('active-cs');
            }

        }
    });
    process.init();
    Backbone.history.start({
        pushState: true
    });

    $(document).on('click', "a[href^='/']", function(e){
        var href = $(this).attr('href');
        passThrough = $(this).attr('pt') || false;
        if (!passThrough && !event.altKey && !event.ctrlKey && !event.metaKey && !event.shiftKey){
            e.preventDefault();
        }
        url = href.replace(/^\//,'').replace('\#\!\/','');
        Router.navigate(url, {
            trigger: true,
        });
        return false;
    });

    $('[data-toggle="tooltip"]').tooltip();
    var feedback = new feedbackView();
    feedback.render();
});