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
], function (router) {

    window.Router = new router.router();

    Backbone.history.on('all', function () {
        var h = location.hash;
        var l = h.substr(1);
        var j = l.split('/')[0];
        $('.navbar-nav li').removeClass('active');
        $('.navbar-nav li.' + j).addClass('active');
    });

    Backbone.history.start();



});