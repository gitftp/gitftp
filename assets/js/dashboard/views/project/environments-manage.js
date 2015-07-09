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
            'submit .project-branch-env-save-form': 'saveBranchForm',
            'click .showftpdetails': 'showFtpDetails'
        },
        showFtpDetails: function(e){
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
                confirm: function(){
                    Router.navigate('#/ftp/edit/'+ ftp_id, {
                        trigger: true
                    });
                }
            });
        },
        saveBranchForm: function (e) {
            var $this = $(e.currentTarget);
            e.preventDefault();
            var form = $this.serializeArray();

            _ajax({
                url: base + 'api/branch/updatebranch',
                data: form,
                method: 'post',
                dataType: 'json'
            }).done(function (data) {
                if (data.status) {
                    app_reload();
                    $.alert({
                        title: 'Updated',
                        content: 'Environment have been updated.' + ((data.message) ? '<br>' + data.message : '')
                    });
                } else {
                    noty({
                        text: '<i class="fa fa-warning fa-fw"></i> '+data.reason
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
            var ftp_id = branch[0]['ftp_id'];

            var ftp = _ajax({
                url: base + 'api/ftp/getall/' + ftp_id,
                method: 'get',
                dataType: 'json',
            });

            var ftp_notUsed = _ajax({
                url: base + 'api/ftp/getall/',
                method: 'get',
                dataType: 'json',
            });

            $.when(ftp, ftp_notUsed).then(function (ftpdata, ftplist) {
                ftpdata = ftpdata[0];
                ftplist = ftplist[0];
                console.log(ftpdata);
                console.log(ftplist);
                that.ftpdata = ftpdata;

                that.template = _.template(envHtml);
                var subPage = that.template({
                    data: that.parent.data.data[0],
                    branch: branch[0],
                    ftp: ftpdata.data[0],
                    ftplist: ftplist,
                });

                $(that.parent.subPage).html(subPage);
            });

        }
    });

    return d;
});