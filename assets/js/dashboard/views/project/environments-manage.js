define([
    'text!pages/project/environments-manage.html',
], function (envHtml) {
    /**
     * Project Env.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit .project-branch-env-save-form': 'saveBranchForm',
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
                        content: 'Settings have been updated.' + (data.message) ? '<br>' + data.message : ''
                    });
                } else {
                    noty({
                        text: data.reason
                    });
                }
            });
        },
        render: function () {
            var that = this;

            if (this.urlp[3]) {
                var branch_id = this.urlp[3];
            } else {
                var back_url = this.urlp.slice(0, 2);
                back_url = back_url.join('/');
                Router.navigate('#/project/' + back_url, {
                    trigger: true
                });
            }

            var branch = $.grep(this.data.data[0].branches, function (a, i) {
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

                that.template = _.template(envHtml);
                var subPage = that.template({
                    data: that.data.data[0],
                    branch: branch[0],
                    ftp: ftpdata.data[0],
                    ftplist: ftplist,
                });

                that.$el.html(subPage);
            });

        }
    });

    return d;
});