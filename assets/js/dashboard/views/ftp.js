define([
    'text!pages/ftplist.html'
], function (ftplist) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .deleteftp': 'deleteftp',
        },
        render: function (id) {
            var that = this;
            that.$el.html('');

            $.getJSON(base + 'api/ftp/getall', function (data) {
                var template = _.template(ftplist);
                template = template({list: data.data});
                that.$el.html(template);
                
                $('[data-toggle="tooltip"]').tooltip();
            });
        },
        deleteftp: function (e) {
            e.preventDefault();

            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            var that = this;

            $.confirm({
                title: 'are you sure?',
                content: 'Are you sure to delete the FTP server.',
                confirm: function () {
                    $.getJSON(base + 'api/ftp/delftp/' + id, function (data) {
                        if (data.status) {
                            console.log(data);
                            noty({
                                text: '!!! Deleted FTP entry.',
                            });
                            that.render();
                        }else{
                            $.alert({
                                'title': 'Something bad happened',
                                'content' : data.reason
                            });
                        }
                    });
                }
            })

        }
    });

    return d;
});