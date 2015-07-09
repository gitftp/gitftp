define([
    'text!pages/ftplist.html'
], function (ftplist) {


    //var ftpcollection = Backbone.Collection.extend({
    //    url: base+ 'api/ftp/getall',
    //    parse: function(response){
    //        return response.data;
    //    }
    //});

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
            this.$el.html(this.el = $('<div class="ftplist-wrapper bb-loading">'));

            _ajax({
                url: base+ 'api/ftp/getall',
                method: 'get',
                dataType: 'json',
            }).done(function(data){
                var template = _.template(ftplist);
                template = template({list: data.data});
                that.el.html(template);
            });


            //test
            //window.ftps = new ftpcollection();
            //console.log(ftps);

        },
    });

    return d;
});