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
            this.$el.html(this.e = $('<div class="bb-loading">').addClass(viewClass()));

            _ajax({
                url: base+ 'api/ftp/get',
                method: 'get',
                dataType: 'json',
            }).done(function(data){
                var template = _.template(ftplist);
                template = template({list: data.data});
                that.e.html(template);
            });
        },
    });

    return d;
});