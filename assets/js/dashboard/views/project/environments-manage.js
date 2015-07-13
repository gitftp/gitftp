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
            'submit .project-branch-env-save-form': 'preventSubmit',
            'submit .project-branch-env-save-form2': 'preventSubmit',
            'click .project-branch-env-save-form-submit': 'saveBranchForm',
            'click .showftpdetails': 'showFtpDetails',
            'click .project-env-edit-revision': 'setRevision',
        },
        setRevision: function (e) {
            var that = this;
            console.log(this.branch);
            var branch_id = this.branch.id;
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
        preventSubmit: function (e) {
            e.preventDefault();
        },
        showFtpDetails: function (e) {
            e.preventDefault();
            var ftp = this.ftpdata.data[0];
            console.log(this.ftpdata.data[0]);
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
                    Router.navigate('#/ftp/edit/' + ftp_id, {
                        trigger: true
                    });
                }
            });
        },
        saveBranchForm: function (e) {
            var $this = $(e.currentTarget);
            e.preventDefault();
            var form = $('.project-branch-env-save-form').serializeArray();

            form.push({
                name: 'skip_path',
                value: this.ftp_skip_el.selectivity('value')
            }, {
                name: 'purge_path',
                value: this.ftp_purge_el.selectivity('value')
            });
            console.log(form);

            _ajax({
                url: base + 'api/branch/updatebranch',
                data: form,
                method: 'post',
                dataType: 'json'
            }).done(function (data) {
                if (data.status) {
                    app_reload();
                    noty({
                        text: '<i class="fa fa-check fa-2x green fa-fw"></i> Changes were saved. ' + data.message
                    })
                } else {
                    noty({
                        text: '<i class="fa fa-warning fa-fw"></i> ' + data.reason,
                    });
                }
            });
        },
        render: function (parent) {
            var that = this;
            this.parent = parent;
            $(that.parent.subPage).html('');


            if (that.parent.urlp[3]) {
                var branch_id = that.parent.urlp[3];
            } else {
                var back_url = that.parent.urlp.slice(0, 2);
                back_url = back_url.join('/');
                Router.navigate('#/project/' + back_url, {
                    trigger: true
                });
            }

            var branch = $.grep(that.parent.data.data[0].branches, function (a, i) {
                return a.id == branch_id;
            });
            this.branch = branch[0];
            var ftp_id = this.branch['ftp_id'];

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

                that.template = _.template(envHtml);
                var subPage = that.template({
                    data: that.parent.data.data[0],
                    branch: that.branch,
                    ftp: ftpdata.data[0],
                    ftplist: ftplist,
                });

                $(that.parent.subPage).html(subPage);

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
            });
        }
    });

    return d;
});