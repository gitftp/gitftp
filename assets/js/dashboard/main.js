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
    "views/actionbar",
], function (router, process, actionbar) {
    if (!is_dash) {
        return false;
    }
    window.Router = new router.router();
    Backbone.history.on('all', function (a, b, c) {
        var l = Backbone.history.getFragment();
        var j = l.split('/')[0] || l.split('/')[1];
        $('.navbar-nav li').removeClass('active');
        if(typeof j === 'undefined')
            j = 'project';
        $('.navbar-nav li.' + j).addClass('active');
    });
    Backbone.history.start({
        pushState: true
    });
    process.init();
    $(document).on('click', "a[href^='/']", function (event) {
        var href = $(this).attr('href');
        passThrough = $(this).attr('pt') || false;
        if (!passThrough && !event.altKey && !event.ctrlKey && !event.metaKey && !event.shiftKey) {
            event.preventDefault();
        }
        url = href.replace(/^\//, '').replace('\#\!\/', '');
        Router.navigate(url, {
            trigger: true
        });
        return false;
    });
    $(document).on('click', '.nav-dropdown ul li a', function (e) {
        $('body').click();
    });
    $('[data-toggle="tooltip"]').tooltip();
    var actionbar = new actionbar();
    actionbar.render();

});