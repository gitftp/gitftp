define([
    'text!pages/settings/hooks.html'
], function (page) {
    d = Backbone.View.extend({
        events: {},
        render: function () {
            var that = this;
            this.$el.html(this.el = $('<div class="bb-loading">').addClass(viewClass()));
            this.template = _.template(page);
            that.el.html(that.template());
        },
    });
    return d;
});