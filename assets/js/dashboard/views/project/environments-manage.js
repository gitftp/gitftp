define([
    'text!pages/project/environments-manage.html',
    'text!pages/project/environments-manage-showftp.html',
], function (envHtml, ftpView) {

    /**
     * Project Env.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .showftpdetails': 'showFtpDetails',
            'click .project-env-edit-revision': 'setRevision',
            'click .env-manage-delete': 'delete',
            'click .project-branch-env-save-form-submit': 'triggerSubmit'
        },
        delete: function (e) {
            e.preventDefault();
            var that = this;
            var $this = $(e.currentTarget);

            $.confirm({
                title: 'Delete',
                content: 'Are you sure to remove this Environment?' +
                '<br> FTP server will be unlinked.',
                confirmButton: 'Delete',
                confirm: function () {
                    var jc = this;
                    _ajax({
                        url: base + 'api/branch/delete',
                        data: {
                            'id': that.branch_id
                        },
                        method: 'post',
                        dataType: 'json'
                    }).done(function (data) {
                        if (data.status) {
                            noty({
                                text: 'Successfully deleted environment',
                                type: 'success'
                            });
                            Router.navigate('/project/' + that.id + '/environments', {
                                trigger: true
                            });
                        } else {
                            $.alert({
                                title: 'Problem',
                                icon: 'fa fa-warning orange',
                                content: data.reason,
                                confirmButton: 'Close'
                            });
                        }

                        jc.close();
                    });
                    return false;
                }
            })
        },
        setRevision: function (e) {
            var that = this;
            var branch_id = this.branch_id;

            $.confirm({
                title: 'Set remote Revision',
                content: 'Gitftp tracks the remote server via this hash,<br>' +
                '<span class="gray small"><i class="fa fa-info"></i>&nbsp; You may change this if you\'ve manually uploaded the files.</span>' +
                '<input type="text" class="form-control mono" autocomplete="off" autocorrect="off" value="' + this.branch.revision + '">',
                confirm: function () {
                    var that = this;
                    var $input = this.$b.find('input');
                    var hash = $input.val();
                    $input.prop('disabled', true);
                    this.$confirmButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Change');
                    this.$cancelButton.prop('disabled', true);

                    _ajax({
                        url: base + 'api/branch/updaterevision',
                        data: {
                            'hash': hash,
                            'id': branch_id
                        },
                        method: 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        if (data.status) {
                            app_reload();
                            that.close();
                        } else {
                            $.alert({
                                title: 'Problem',
                                content: data.reason,
                                columnClass: that.columnClass,
                            })
                        }
                    }).always(function () {
                        that.$confirmButton.prop('disabled', false).find('i').remove();
                        that.$cancelButton.prop('disabled', false);
                        $input.prop('disabled', false);
                    });

                    return false;
                },
                confirmButton: 'Change',
                backgroundDismiss: false,
                columnClass: 'col-md-4 col-md-offset-4'
            })
        },
        showFtpDetails: function (e) {
            e.preventDefault();

            var ftp = this.ftpdata.data[0];
            var template = _.template(ftpView);
            template = template({
                ftp: ftp
            });
            var ftp_id = ftp.id;
            $.confirm({
                title: ' ',
                content: template,
                confirmButton: 'Manage FTP',
                confirmButtonClass: 'btn-default btn-clean',
                cancelButtonClass: 'btn-primary',
                cancelButton: 'Dismiss',
                confirm: function () {
                    Router.navigate('/ftp/edit/' + ftp_id, {
                        trigger: true
                    });
                },
                columnClass: 'col-md-6 col-md-offset-3'
            });
        },
        saveBranchForm: function () {
            var $this = this.$form;
            var form = $this.serializeArray();

            form.push({
                name: 'skip_path',
                value: this.ftp_skip_el.selectivity('value')
            }, {
                name: 'purge_path',
                value: this.ftp_purge_el.selectivity('value')
            });

            var ftpselected = $('#env_ftp_select').val();
            var ftpselectedbefore = $('#env_ftp_select').attr('data-before');
            if (ftpselected !== ftpselectedbefore) {
                $.confirm({
                    title: 'FTP server changed.',
                    icon: 'fa fa-info orange',
                    content: 'Are you sure to re-link FTP server? <br>' +
                    'Environment will be reset.',
                    confirm: function () {
                        save();
                    },
                    confirmButton: 'Continue'
                })
            } else {
                save();
            }

            function save() {
                _ajax({
                    url: base + 'api/branch/updatebranch',
                    data: form,
                    method: 'post',
                    dataType: 'json'
                }).done(function (data) {
                    if (data.status) {
                        app_reload();
                        noty({
                            text: '<i class="fa fa-check fa-fw"></i> Changes were saved. ' + data.message,
                            type: 'success',
                        })
                    } else {
                        noty({
                            text: '<i class="fa fa-warning fa-fw"></i> ' + data.reason,
                            type: 'error',
                        });
                    }
                });
            }
        },
        triggerSubmit: function (e) {
            e.preventDefault();
            this.$form.submit();
        },
        validation: function () {
            var that = this;

            that.$form.validate({
                submitHandler: function (form) {
                    that.saveBranchForm();

                    return false;
                },
                rules: {
                    'name': {
                        required: true,
                        maxlength: 50,
                    },
                    'ftp_id': {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        maxlength: 'Name cannot be longer than 50 chars'
                    }
                }
            })
        },
        render: function (id, urlp) {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading project-activity-anim">').addClass(viewClass()));
            this.id = id;
            if (urlp[3]) {
                this.branch_id = urlp[3];
            } else {
                window.history.back();
            }

            _ajax({
                url: base + 'api/branch/get',
                data: {
                    branch_id: this.branch_id
                },
                method: 'get',
                dataType: 'json'
            }).done(function (data) {

                that.branch = data.data[0];
                var ftp_id = that.branch['ftp_id'];
                var ftp = _ajax({
                    url: base + 'api/ftp/get/' + ftp_id,
                    method: 'get',
                    dataType: 'json',
                });

                var ftp_notUsed = _ajax({
                    url: base + 'api/ftp/get/',
                    method: 'get',
                    dataType: 'json',
                });

                $.when(ftp, ftp_notUsed).then(function (ftpdata, ftplist) {
                    ftpdata = ftpdata[0];
                    ftplist = ftplist[0];
                    that.ftpdata = ftpdata;
                    that.ftplist = ftplist;

                    console.log(that.branch);

                    that.template = _.template(envHtml);
                    var subPage = that.template({
                        branch: that.branch,
                        ftp: ftpdata.data[0],
                        ftplist: ftplist,
                    });
                    that.$e.html(subPage);

                    that.ftp_skip_el = $('.selective-skip');
                    that.ftp_skip_el.selectivity({
                        inputType: 'Email',
                        placeholder: 'Add file patterns to skip',
                        value: that.branch.skip_path,
                    });

                    that.ftp_purge_el = $('.selective-purge');
                    that.ftp_purge_el.selectivity({
                        inputType: 'Email',
                        placeholder: 'folders to purge',
                        value: that.branch.purge_path,
                    });

                    that.$form = $('.project-branch-env-save-form');
                    that.validation();
                });
            });
            setTitle('Manage environment | Projects');
        }
    });

    return d;
});