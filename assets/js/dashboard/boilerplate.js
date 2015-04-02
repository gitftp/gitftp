define([], function () {
    Booking = Backbone.View.extend({
        title: 'Bookings',
        el: app.config.el,
        render: function (id) {
            func.setTitle(this);
            var that = this;
            func.getView('booking', function (d) {
                that.html = d;
                that.$el.html(_.template(that.html, {title: that.title}));
                func.bindPlugins();
            });
        }
    });
    return Booking;
});