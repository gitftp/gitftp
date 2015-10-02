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
            'click button.ftp-form-password-set-cancel': 'passwordFieldToggle'
        },
        passwordFieldToggle: function (e) {
            console.log(e.currentTarget);

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
                        '<br> <a target="_blank" href="/project/' + branch['deploy_id'] + '/environments/manage/' + branch['id'] + '">' + branch['project_name'] + ' - <i class="fa fa-leaf green"></i> ' + branch['branch_name'] + '</a>',
                        confirmButton: 'Unlink',
                        cancelButton: 'Close',
                        confirm: function () {
                            Router.navigate('/project/' + branch['deploy_id'] + '/environments/manage/' + branch['id'], {
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
            var that = this;
            var $this = $(e.currentTarget);
            var form = $('#addftp-form').serializeObject();
            if (!form.scheme || !form.host || !form.username) {
                $.alert({
                    title: 'Please enter necessary fields',
                    content: 'Please enter enough data to connect to FTP server.'
                });
                return false;
            }
            $this.prop('disabled', true).find('i').addClass('gf gf-loading gf-btn');

            _ajax({
                url: base + 'api/ftp/testftp',
                dataType: 'json',
                method: 'post',
                data: form
            }).done(function (d) {
                if (d.status) {
                    $.alert({
                        container: that.$e,
                        title: 'Successful',
                        content: 'Connection established successfully, This FTP config is ready to be Linked with a project.',
                        icon: 'fa fa-check green fa-fw'
                    });
                } else {
                    $.confirm({
                        container: that.$e,
                        title: 'Problem',
                        content: 'The connection could not be established. <br>Reason: <code>' + d.reason + '</code>',
                        icon: 'fa fa-info orange fa-fw',
                        confirmButton: 'Retry',
                        cancelButton: 'Dismiss',
                        confirm: function () {
                            $('.ftp-connectionTest').click();
                        }
                    });
                }

                $this.prop('disabled', false).find('i').removeClass('gf gf-loading gf-btn');
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

            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));

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
                    that.$e.html(template);
                    that.oneline();
                    that.validation();
                });
                that.id = id;
                setTitle('Edit ftp server');
            } else {
                var template = _.template(ftpadd);
                template = template({
                    'ftp': []
                });
                that.$e.html(template);
                that.id = false;
                that.validation();
                setTitle('Add ftp server');
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
                return !/(\/)\1+/ig.test(value) && /^\/|^\\/.test(value);
            }, 'Path must contain a leading slash');
            $.validator.addMethod('validateScheme', function (value) {
                return value == 'ftp' || value == 'ftps' || value == 'sftp';
            }, 'Please enter a valid schema.');
            $.validator.addMethod('validateHost', function (value) {
                return that.hostValidate.test(value) || that.ipValidate.test(value);
            }, 'Please enter a valid host/IP.');
        },
        add: function (form) {
            var that = this;
            var $this = $(form);
            var data = $this.serializeArray();
            var param = (this.id) ? 'editftp/' + this.id : 'addftp';

            $this.find(':input').prop('disabled', true);

            var $submitBtn = $this.find('button[type="submit"]');
            $submitBtn.html('<i class="gf gf-loading gf-btn"></i> Updating');
            _ajax({
                url: base + 'api/ftp/' + param,
                data: data,
                method: 'post',
                dataType: 'json'
            }).done(function (data) {
                $this.find(':input:not([data-notform="true"])').prop('disabled', false);
                if (data.status) {
                    if (that.executeAfterAdd) {
                        that.executeAfterAdd();
                        return false;
                    }
                    noty({
                        text: ((that.id) ? 'Your changed are saved.' : 'Added FTP server: ' + $this.find('[name="host"]').val() ),
                        type: 'success'
                    });
                    Router.navigate('ftp', {trigger: true});
                } else {
                    noty({
                        text: data.reason,
                        type: 'warning'
                    });
                }
                $submitBtn.html('Update');
            });
        },
    });

    return d;
});