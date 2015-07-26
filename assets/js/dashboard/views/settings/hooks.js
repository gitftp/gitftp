define([
    'text!pages/settings/hooks.html'
], function (page) {
    d = Backbone.View.extend({
        events: {},
        render: function () {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));
            this.template = _.template(page);
            that.$e.html(that.template());
        },
    });
    return d;
});