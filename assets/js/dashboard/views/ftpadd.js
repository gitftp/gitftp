define([
    'text!pages/ftpadd.html'
], function (ftpadd) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit #addftp-form': 'addftp',
            'keyup #addftp-form input': 'oneline'
        },
        
        oneline: function () {
            var $target = $('.ftp-oneline');
            var str = '';
            var host = $('input[name="host"]').val();
            var username = $('input[name="username"]').val();
            var pass = $('input[name="pass"]').val();
            var scheme = $('input[name="scheme"]').val();
            var path = $('input[name="path"]').val();
            var port = $('input[name="port"]').val();


            if (host) {
                if (scheme) {
                    str += scheme + '://';
                } else {
                    str += 'ftp://';
                }
                if (username) {
                    str += username;
                    if (pass) {
                        str += ':' + pass;
                    }
                    str += '@';
                }
                if (host) {
                    str += host;
                }
                if (port) {
                    str += ':' + port;
                } else {
                    str += ':21';
                }
                if (path) {
                    str += '' + path;
                } else {
                    str += '/';
                }
            }

            if (str === '') {
                str = 'ftp://example:password@production-example.com:21/path/to/installation';
            }

            $target.html(str);
        },
        render: function (id) {
            var that = this;
            that.$el.html('');
            that.$el.html(ftpadd);
        },
        addftp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            $this.find('select, input').attr('readonly', true);

            $.post(base + 'api/ftp/addftp', $this.serializeArray(), function (data) {
                $this.find('select, input').removeAttr('readonly');
                data = JSON.parse(data);
                if (data.status) {
                    noty({
                        text: '!!! Added FTP server: ' + $this.find('[name="host"]').val()
                    });
                    Router.navigate('ftp', {trigger: true});
                }
            });
        }
    });

    return d;
});