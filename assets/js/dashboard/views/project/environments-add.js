define([
    'text!pages/project/environments-add.html',
    'text!pages/project/environment-add-ftplist.html'
], function (envHtml, ftplistHtml) {
    /**
     * Project Env add.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .load-branches': 'renderContent',
            'submit .project-branch-new-env-save-form': 'createEnv',
            'change #ftp-list': 'loadFtpDetails'
        },
        loadFtpDetails: function (e) {
            var $this = $(e.currentTarget);
            var $ftpcontainer = $('.ftp-details');

            _ajax({
                url: dash_url + 'api/ftp/getall/' + $this.val(),
                method: 'get',
                dataType: 'json'
            }).done(function (response) {

                var template = _.template(ftplistHtml);

                template = template({
                    ftp: response.data[0]
                });

                $('.ftp-details').html(template);
            })
        },
        createEnv: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var data = $this.serializeArray();

            data.push({
                name: 'deploy_id',
                value: this.parent.id
            });

            _ajax({
                url: dash_url + 'api/branch/create',
                data: data,
                method: 'post',
                dataType: 'json',
            }).done(function (response) {
                if (response.status) {
                    $.alert({
                        title: 'Added',
                        content: 'A new Environment was successfully added.'
                    });
                } else {
                    $.alert({
                        title: 'Problem',
                        content: response.reason,
                    });
                }
            });

        },
        render: function (parent) {
            var that = this;
            this.parent = parent;
            var deploy = that.parent.data.data[0];

            that.template = _.template(envHtml)
            var subPage = that.template({
                data: deploy,
            });

            $(this.parent.subPage).html('');
            $(this.parent.subPage).html(subPage);

            this.renderContent();
        },
        renderContent: function () {
            $('.load-branches').prop('disabled', true).find('i').addClass('fa-spin');


            $.when(this.getBranches(), this.getFtp()).then(function (branches, ftp) {
                console.log(branches, ftp);
                var branches_list = '',
                    ftp_list = '<option value="0">(select)</option>';

                $.each(branches[0].data, function (i, a) {
                    branches_list += '<option value="' + a + '">' + a + '</option>';
                });

                $.each(ftp[0].data, function (i, a) {
                    ftp_list += '<option value="' + a.id + '">' + a.name + '</option>';
                });

                $('#branches-list').html(branches_list);
                $('#ftp-list').html(ftp_list);
                $('.load-branches').prop('disabled', false).find('i').removeClass('fa-spin');
            });
        },
        getBranches: function () {
            return _ajax({
                url: dash_url + 'api/deploy/getbranches',
                data: {
                    'deploy_id': this.parent.id
                },
                method: 'post',
                dataType: 'json'
            });
        },
        getFtp: function () {
            return _ajax({
                url: dash_url + 'api/ftp/getall',
                method: 'get',
                dataType: 'json'
            });
        }
    });

    return d;
});