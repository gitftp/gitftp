define([
    'text!pages/ftpadd.html'
], function (ftpadd) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit #addftp-form': 'addftp'
        },
        render: function (id) {
            var that = this;
            that.$el.html(ftpadd);
        },
        addftp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            $.post(base + 'api/ftp/addftp', $this.serializeArray(), function (data) {
                data = JSON.parse(data);
                
            });
        }
    });

    return d;
});