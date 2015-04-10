define([
    'text!pages/dashboard.html'
], function (page) {
    d = Backbone.View.extend({
        el: app.el,
        render: function (id) {
            var that = this;
            that.$el.html(page);
        }
    });
    return d;
});
        