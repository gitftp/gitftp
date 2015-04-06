define([
    'text!pages/projectview.html'
], function (main) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .startdeploy': 'startDeploy'
        },
        render: function (id, which) {
            
            var that = this;
            this.which = which || 'main';
            
            this.page = {
                main: main,
            };

            that.$el.html('');
            this.template = _.template(this.page.main);
            this.id = id;
            $.getJSON(base + 'api/deploy/getall/' + id, function (data) {
                var template = that.template({'list': data.data});
                that.$el.html(template);
            });
        },
        startDeploy: function () {
            $.get(base + 'api/deploy/start/' + this.id, function (data) {
                console.log(data);
            });
        }
    });

    return d;
});