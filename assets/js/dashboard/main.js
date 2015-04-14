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
        var k = h.split('/');
        
        $('.navbar-nav li').removeClass('active');
        $('.navbar-nav li.' + j).addClass('active');
        
        if(/deploy/ig.test(k[0])){
            
            $subpage = $('.page-subview');
            try{
                
            }catch ()
            var l = k[3];
            $subpage.removeClass('active-cs');
            if(l){
                $('.subview-'+l).addClass('active-cs');
            }else{
                $('.subview-activity').addClass('active-cs');
            }
            
        }
//        subview
    });
    process.init();
    Backbone.history.start();

});