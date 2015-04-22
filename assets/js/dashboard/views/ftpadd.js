define([
    'text!pages/ftpadd.html'
], function (ftpadd) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit #addftp-form': 'addftp',
            'keyup #addftp-form input': 'oneline',
            'click .ftp-connectionTest': 'testFtp',
            'click .ftp-server-delete': 'deleteftp',
        },
        deleteftp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            var that = this;
            $this.find('i').removeClass('fa-trash').addClass('fa-spin fa-spinner').attr('disabled', true);
            $.confirm({
                title: 'Are you sure?',
                content: 'Are you sure to remove the FTP server.<br><i class="fa fa-info"></i> files in the server will remain intact.',
                confirm: function () {
                    $this.find('i').addClass('fa-trash').removeClass('fa-spin fa-spinner').removeAttr('disabled');
                    $.getJSON(base + 'api/ftp/delftp/' + id, function (data) {
                        if (data.status) {
                            console.log(data);
                            noty({
                                text: 'Deleted FTP server.',
                            });
                            Router.navigate('ftp', {
                                trigger: true
                            });
                        } else {
                            $.alert({
                                'title': 'Something bad happened',
                                'content': data.reason
                            });
                        }
                    });
                },
                cancel: function(){
                    $this.find('i').addClass('fa-trash').removeClass('fa-spin fa-spinner').removeAttr('disabled');
                }
            });

        },
        testFtp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var form = $('#addftp-form').serializeArray();
            $this.find('i').removeClass('fa-exchange').addClass('fa-spin fa-spinner').prop('disabled', true);
            
            _ajax({
                url: base + 'api/ftp/testftp',
                dataType: 'json',
                method: 'post',
                data: form
            }).done(function (d) {
                $.alert({
                    title: (d.status) ? '<i class="fa fa-check green"></i> Successful' : '<i class="fa fa-times red"></i> Falied',
                    content: (d.status) ? 'Connection established successfully.' : 'We tried hard connecting, but failed. <br>Reason: '+d.reason
                });
                $this.find('i').addClass('fa-exchange').removeClass('fa-spin fa-spinner').removeAttr('disabled');
            });
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

            if (/^(?!:\/\/)([a-zA-Z0-9]+\.)?[a-zA-Z0-9][a-zA-Z0-9-]+\.[a-zA-Z]{2,6}?$/i.test(host) || /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(host)) {
                if (scheme && /ftp|ftps|sftp/.test(scheme)) {
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

            this.$el.html(this.el = $('<div class="ftpadd-wrapper bb-loading">'));
            if (id) {

                _ajax({
                    url: base + 'api/ftp/getall/' + id,
                    dataType: 'json',
                    method: 'get',
                }).done(function (data) {
                    var template = _.template(ftpadd);
                    template = template({
                        'ftp': data.data
                    });
                    that.el.html(template);
                    if (id) {
                        that.oneline();
                    }
                });
                that.id = id;
            } else {
                var template = _.template(ftpadd);
                template = template({
                    'ftp': []
                });
                that.el.html(template);
                that.id = false;
            }
        },
        addftp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            $this.find('select, input').attr('readonly', true);
            var that = this;

            if (this.id) {
                var to = 'editftp/' + this.id;
            } else {
                var to = 'addftp';
            }

            _ajax({
                url: base + 'api/ftp/' + to,
                data: $this.serializeArray(),
                method: 'post',
                dataType: 'json'
            }).done(function (data) {

                $this.find('select, input').removeAttr('readonly');
                if (data.status) {
                    noty({
                        text: ((this.id) ? 'Edited' : 'Added') + ' FTP server: ' + $this.find('[name="host"]').val()
                    });
                    Router.navigate('ftp', {trigger: true});
                } else {
                    $.alert({
                        title: 'Something bad happened',
                        content: data.reason
                    });
                }

            });
        }
    });

    return d;
});