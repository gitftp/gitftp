define([
    'text!pages/dashboard.html'
], function (page) {
    d = Backbone.View.extend({
        el: app.el,
        render: function (id) {
            var that = this;
            this.template = _.template(page);
            _ajax({
                url : base+'api/deploy/dashdata',
                method: 'get',
                dataType: 'json',
            }).done(function(data){
                that.$el.html(that.template(data));
            })
        },
    });
    return d;
});