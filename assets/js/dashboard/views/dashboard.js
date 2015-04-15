define([
    'text!pages/dashboard.html'
], function (page) {
    d = Backbone.View.extend({
        el: app.el,
        render: function (id) {
            var that = this;
            this.$el.html(this.el = $('<div class="dashboard-wrapper bb-loading">'));
            
            this.template = _.template(page);
            _ajax({
                url : base+'api/deploy/dashdata',
                method: 'get',
                dataType: 'json',
            }).done(function(data){
                that.el.html(that.template({data: data}));
            });
        },
    });
    return d;
});