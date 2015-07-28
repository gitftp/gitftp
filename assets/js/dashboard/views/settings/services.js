define([
    'text!pages/settings/services.html'
], function (page) {
    d = Backbone.View.extend({
        events: {
            'click .connectwithgithub': 'github'
        },
        render: function () {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));
            this.template = _.template(page);
            that.$e.html(that.template());
        },
        github: function (e) {
            e.preventDefault();
            window.location.href = home_url+'api/user/oauth/github';
        }
    });
    return d;
});