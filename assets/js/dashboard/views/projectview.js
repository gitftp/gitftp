define([
    'text!pages/projectview.html'
], function (page) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .startdeploy': 'startDeploy'
        },
        render: function (id, page) {
            var that = this;
            console.log(arguments);
            that.$el.html('');
            this.page = page;
            this.template = _.template(this.page);
            this.id = id;
            $.getJSON(base + 'api/deploy/getall/'+id, function (data) {
                var template = that.template({'list': data.data});
                that.$el.html(template);
            });
        },
        startDeploy: function(){
            $.get(base+'api/deploy/start/'+this.id, function(data){
                console.log(data);
            });
        }
    });

    return d;
});