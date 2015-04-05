define([
    'text!pages/projectview.html'
], function (base) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .startdeploy': 'startDeploy'
        },
        render: function (id, whichpage) {
            var that = this;
            that.$el.html('');
            this.page = {
                base: base
            };
            this.template = _.template(this.page.base);
            this.id = id;
            
            $.getJSON(base + 'api/deploy/getall/'+id, function (data) {                
                var template = that.template({'s': data.data[0]});
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