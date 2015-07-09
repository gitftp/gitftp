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
            'click .ftp-form-password-set-change': 'passwordFieldToggle',
            'click .ftp-form-password-set-cancel': 'passwordFieldToggle',
        },
        passwordFieldToggle: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);

            var $set = $('.ftp-form-password-set'),
                $field = $('.ftp-form-password-field');

            if ($field.is(':visible')) {
                $field.find('input').prop('disabled', true);
                $field.hide();
                $set.show();
            } else {
                $field.show();
                $set.hide();
                $field.find('input').prop('disabled', false);
            }
            this.oneline();
        },
        deleteftp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            var that = this;
            $this.find('i').removeClass('fa-trash').addClass('fa-spin fa-spinner').attr('disabled', true);

            _ajax({
                url: base + 'api/ftp/isftpinuse',
                data: {
                    id: id,
                },
                method: 'get',
                dataType: 'json',
            }).done(function (data) {
                if (!data.status) {
                    $.confirm({
                        title: 'Are you sure?',
                        content: 'Are you sure to remove the FTP server.<br><i class="fa fa-info"></i> Files on this server will not be deleted.',
                        confirm: function () {
                            $this.find('i').addClass('fa-trash').removeClass('fa-spin fa-spinner').removeAttr('disabled');

                            _ajax({
                                url: base + 'api/ftp/delftp/' + id,
                                method: 'get',
                                dataType: 'json',
                            }).done(function (data) {
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
                        cancel: function () {
                            $this.find('i').addClass('fa-trash').removeClass('fa-spin fa-spinner').removeAttr('disabled');
                        },
                        confirmButton: 'Remove',
                    });
                } else {
                    console.log(data.used_in);
                    branch = data.used_in[0];
                    $.confirm({
                        title: 'Linked with — <i class="fa fa-cloud"></i> '+branch['project_name'],
                        content: 'In order to remove this ftp, please unlink it from the existing enviornment. ' +
                        '<br> <a target="_blank" href="#/project/'+branch['deploy_id']+'/environments/manage/'+branch['id']+'">'+branch['project_name']+' - <i class="fa fa-leaf green"></i> '+branch['branch_name']+'</a>',
                        confirmButton: 'Unlink',
                        cancelButton: 'Dismiss',
                        confirm: function(){
                            Router.navigate('#/project/'+branch['deploy_id']+'/environments/manage/'+branch['id'], {
                                trigger: true,
                            });
                        },
                        cancel: function () {
                            $this.find('i').addClass('fa-trash').removeClass('fa-spin fa-spinner').removeAttr('disabled');
                        }
                    });
                }
            });
        },
        testFtp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var form = $('#addftp-form').serializeArray();
            $this.find('i').removeClass('fa-exchange').addClass('fa-spin fa-spinner');
            $this.prop('disabled', true);

            _ajax({
                url: base + 'api/ftp/testftp',
                dataType: 'json',
                method: 'post',
                data: form
            }).done(function (d) {
                $.alert({
                    title: (d.status) ? '<i class="fa fa-check green"></i> Connection successful' : 'Problem',
                    content: (d.status) ? 'Connection established successfully.' : 'We tried hard connecting, but failed. <br>Reason: <code>' + d.reason + '</code>',
                });
                $this.find('i').addClass('fa-exchange').removeClass('fa-spin fa-spinner');
                $this.prop('disabled', false);
            });
        },
        oneline: function () {
            var $target = $('.ftp-oneline');
            var str = '';
            var host = $('input[name="host"]').val();
            var username = $('input[name="username"]').val();
            var pass = $('input[name="pass"]:not(:disabled)').val();
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
                        pass = pass.split('');
                        pass = $.map(pass, function () {
                            return '*';
                        });
                        str += ':' + pass.join('');
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
                        text: ((that.id) ? 'Edited' : 'Added') + ' FTP server: ' + $this.find('[name="host"]').val()
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