define([
    'text!pages/ftpadd.html'
], function (ftpadd) {
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'keyup #addftp-form input': 'oneline',
            'click .ftp-connectionTest': 'testFtp',
            'click .ftp-server-delete': 'deleteftp',
            'click a.ftp-form-password-set-change': 'passwordFieldToggle',
            'click button.ftp-form-password-set-cancel': 'passwordFieldToggle',
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
                        title: 'Remove FTP account?',
                        content: 'Are you sure to remove the FTP server.<br><i class="fa fa-info blue"></i>&nbsp; Files on this server will not be deleted.',
                        confirm: function () {
                            $this.find('i').addClass('fa-trash').removeClass('fa-spin fa-spinner').removeAttr('disabled');

                            _ajax({
                                url: base + 'api/ftp/delftp/' + id,
                                method: 'get',
                                dataType: 'json',
                            }).done(function (data) {
                                if (data.status) {
                                    noty({
                                        text: 'The ftp server was deleted.',
                                        type: 'success'
                                    });
                                    Router.navigate('ftp', {
                                        trigger: true
                                    });
                                } else {
                                    $.alert({
                                        'title': 'Problem',
                                        'content': data.reason
                                    });
                                }
                            });
                        },
                        cancel: function () {
                            $this.find('i').addClass('fa-trash').removeClass('fa-spin fa-spinner').removeAttr('disabled');
                        },
                        confirmButtonClass: 'btn-warning',
                        confirmButton: '<i class="fa fa-trash"></i>&nbsp; Remove',
                    });
                } else {
                    console.log(data.used_in);
                    branch = data.used_in[0];
                    $.confirm({
                        title: 'Linked with — <i class="fa fa-cloud"></i> ' + branch['project_name'],
                        content: 'Cannot delete a FTP account that is in use, please unlink it from the existing enviornment. ' +
                        '<br> <a target="_blank" href="#/project/' + branch['deploy_id'] + '/environments/manage/' + branch['id'] + '">' + branch['project_name'] + ' - <i class="fa fa-leaf green"></i> ' + branch['branch_name'] + '</a>',
                        confirmButton: 'Unlink',
                        cancelButton: 'Close',
                        confirm: function () {
                            Router.navigate('#/project/' + branch['deploy_id'] + '/environments/manage/' + branch['id'], {
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
        hostValidate: /^(?!:\/\/)([a-zA-Z0-9]+\.)?[a-zA-Z0-9][a-zA-Z0-9-]+\.[a-zA-Z]{2,6}?$/i,
        ipValidate: /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/,
        oneline: function () {
            var $target = $('.ftp-oneline');
            var str = '';
            var host = $('input[name="host"]').val();
            var username = $('input[name="username"]').val();
            var pass = $('input[name="pass"]:not(:disabled)').val();
            var scheme = $('input[name="scheme"]').val();
            var path = $('input[name="path"]').val();
            var port = $('input[name="port"]').val();

            if (this.hostValidate.test(host) || this.ipValidate.test(host)) {
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

            this.$el.html(this.el = $('<div class="bb-loading">').addClass(viewClass()));
            if (id) {
                _ajax({
                    url: base + 'api/ftp/get/' + id,
                    dataType: 'json',
                    method: 'get',
                }).done(function (data) {
                    var template = _.template(ftpadd);
                    template = template({
                        'ftp': data.data
                    });
                    that.el.html(template);
                    that.oneline();
                    that.validation();
                });
                that.id = id;
            } else {
                var template = _.template(ftpadd);
                template = template({
                    'ftp': []
                });
                that.el.html(template);
                that.id = false;
                that.validation();
            }
        },
        validation: function () {
            var that = this;
            $('#addftp-form').validate({
                debug: true,
                submitHandler: function (form) {
                    that.add(form);

                    return false;
                },
                errorClass: 'error',
                rules: {
                    'name': {
                        required: true
                    },
                    'scheme': 'validateScheme',
                    'host': 'validateHost',
                    'username': {
                        required: true,
                    },
                    'path': 'validatePath',
                    'port': {
                        required: true,
                        number: true,
                    }
                }
            });
            $.validator.addMethod('validatePath', function (value) {
                return value.substr(0, 1) == '/';
            }, 'Path must contain a leading slash');
            $.validator.addMethod('validateScheme', function (value) {
                return value == 'ftp' || value == 'ftps';
            }, 'Please enter a valid schema.');
            $.validator.addMethod('validateHost', function (value) {
                return that.hostValidate.test(value) || that.ipValidate.test(value);
            }, 'Please enter a valid host/IP.');
        },
        add: function (form) {
            var that = this;
            $this = $(form);

            $this.find('select, input').attr('readonly', true);
            var that = this;
            var param = (this.id) ? 'editftp/' + this.id : 'addftp';

            _ajax({
                url: base + 'api/ftp/' + param,
                data: $this.serializeArray(),
                method: 'post',
                dataType: 'json'
            }).done(function (data) {
                $this.find('select, input').removeAttr('readonly');
                if (data.status) {
                    noty({
                        text: ((that.id) ? '<i clas="fa fa-pencil"></i>&nbsp; Your changed are saved.' : '<i class="fa fa-plus"></i>&nbsp; Added FTP server: ' + $this.find('[name="host"]').val() ),
                        type: 'success',
                    });
                    Router.navigate('ftp', {trigger: true});
                } else {
                    noty({
                        text: '<i class="fa fa-times"></i>&nbsp; ' + data.reason,
                        type: 'warning',
                    });
                }
            });
        },
    });

    return d;
});