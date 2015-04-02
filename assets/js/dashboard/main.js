window.app = {
    el: $('.bb-wrapper'),
    obj: {}
};

/*
 * Require JS starts here.
 */

require([
    "router"
], function (router) {
    window.Router = new router.router();
    Backbone.history.start();
});