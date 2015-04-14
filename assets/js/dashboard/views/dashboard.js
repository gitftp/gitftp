define([
    'text!pages/dashboard.html'
], function (page) {
    d = Backbone.View.extend({
        el: app.el,
        render: function (id) {
            var that = this;
            _ajax({
                url : base+'api/deploy/dashdata',
            }).done(function(data){
                that.$el.html(page);
            })
        },
    });
    return d;
});