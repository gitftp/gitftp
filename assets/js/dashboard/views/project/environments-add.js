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
            'click .load-branches': 'renderBranches',
            'click .env-new-form-submit-button': 'submitForm'
        },
        renderBranches: function (e) {
            var $this = $(e.currentTarget);
            var that = this;
            $this.prop('disabled', true).find('i').addClass('fa-spin');
            $this.parent().prev().prop('disabled', true);

            this.getBranches().done(function (data) {
                var options = '';
                $.each(data.data, function (i, a) {
                    options += '<option value="' + a + '">' + a + '</option>';
                });
                $('#branches-list').html(options);
            }).always(function (data) {
                $this.prop('disabled', false).find('i').removeClass('fa-spin');
                $this.parent().prev().prop('disabled', false);
            });
        },
        submitForm: function (e) {
            e.preventDefault();
            this.$form.submit();
        },
        add: function (form) {
            var that = this;
            var $this = $(form);
            var data = $this.serializeArray();

            if (!this.$form.valid()) {
                return false;
            }

            data.push({
                name: 'deploy_id',
                value: this.id
            }, {
                name: 'skip_path',
                value: this.ftp_skip_el.selectivity('value')
            }, {
                name: 'purge_path',
                value: this.ftp_purge_el.selectivity('value')
            });

            _ajax({
                url: dash_url + 'api/branch/create',
                data: data,
                method: 'post',
                dataType: 'json'
            }).done(function (response) {
                if (response.status) {
                    noty({
                        text: 'Successfully created a new Environment.',
                        type: 'success'
                    });
                    Router.navigate('/project/' + that.id + '/environments', {
                        trigger: true
                    });
                } else {
                    $.alert({
                        title: 'Problem',
                        content: response.reason
                    });
                }
            });
        },
        validation: function () {
            var that = this;
            this.$form.validate({
                debug: true,
                submitHandler: function (form) {
                    that.add(form);

                    return false;
                },
                errorClass: 'error',
                rules: {
                    'name': {
                        required: true,
                        maxlength: 50,
                    },
                    'branch_name': {
                        required: true,
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
        initialize: function () {
            this.template = _.template(envHtml)
        },
        render: function (id) {
            var that = this;
            this.id = id;
            this.$el.html(this.$e = $('<div class="bb-loading project-activity-anim">').addClass(viewClass()));
            var subPage = that.template();
            this.$e.html(subPage);
            this.$panel = $('.branch-single-view');
            this.$form = $('.project-branch-new-env-save-form');
            this.$panel.find(':input').attr('disabled', 'disabled')
                .end().addClass('panel-loading');

            that.ftp_skip_el = $('.selective-skip');
            that.ftp_skip_el.selectivity({
                inputType: 'Email',
                placeholder: 'Add file patterns to skip'
            });

            that.ftp_purge_el = $('.selective-purge');
            that.ftp_purge_el.selectivity({
                inputType: 'Email',
                placeholder: 'folders to purge'
            });

            this.validation();
            this.renderContent();
            setTitle('New environment | Projects');
        },
        renderContent: function () {
            var that = this;
            $.when(this.getBranches(), this.getFtp()).then(function (branches, ftp) {
                console.log(branches, ftp);
                var branches_list = '',
                    ftp_list = '<option value="">Select a FTP server</option>';

                $.each(branches[0].data, function (i, a) {
                    branches_list += '<option value="' + a + '">' + a + '</option>';
                });

                $.each(ftp[0].data, function (i, a) {
                    ftp_list += '<option value="' + a.id + '">' + a.name + '</option>';
                });

                $('#branches-list').html(branches_list);
                $('#ftp-list').html(ftp_list);

                that.$panel.find(':input').removeAttr('disabled')
                    .end().removeClass('panel-loading');

                $('input[name="name"]').focus();
            });
        },
        getBranches: function () {
            return _ajax({
                url: dash_url + 'api/etc/getremotebranches',
                data: {
                    'deploy_id': this.id
                },
                method: 'post',
                dataType: 'json'
            });
        },
        getFtp: function () {
            return _ajax({
                url: dash_url + 'api/ftp/get',
                method: 'get',
                dataType: 'json'
            });
        }
    });

    return d;
});