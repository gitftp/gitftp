define([
    'text!pages/ftplist.html'
], function (ftplist) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .ftp-servers-list': 'viewFtp'
        },
        viewFtp: function(e){
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            Router.navigate('#ftp/edit/'+id, {
                trigger: true
            });
        },
        render: function (id) {
            var that = this;
            this.el = $('<div class="ftpadd-wrapper bb-loading">').appendTo(this.$el);

            $.getJSON(base + 'api/ftp/getall', function (data) {
                var template = _.template(ftplist);
                template = template({list: data.data});
                that.el.html(template);
                
                $('[data-toggle="tooltip"]').tooltip();
            });
        },
    });

    return d;
});