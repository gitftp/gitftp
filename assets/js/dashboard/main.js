window.app = {
    el: $('.bb-wrapper'),
    obj: {}
};

/*
 * Require JS starts here.
 */

require([
    "router",
    "process"
], function (router, process) {

    if (!is_dash) {
        return false;
    }

    window.Router = new router.router();
    Backbone.history.on('all', function () {
        var h = location.hash;
        var l = h.substr(1);
        var j = l.split('/')[0];
        $('.navbar-nav li').removeClass('active');
        $('.navbar-nav li.' + j).addClass('active');
        $subpage = $('.page-subview');
        if($subpage.length){
            var k = h.split('/');
            var l = k[k.length-1];
            $subpage.removeClass('active-cs');
            $('.subview-'+l).addClass('active-cs');
        }
//        subview
    });
    process.init();
    Backbone.history.start();

});