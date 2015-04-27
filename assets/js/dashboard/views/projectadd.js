define([
    'text!pages/projectadd.html'
], function (page) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click #deploy-save-new': 'savenew',
            'submit #add-deploy-form': 'preventform',
            'keyup input#add-repo': 'calcname',
            'change #deploy-add-privaterepo': 'priCheck',
            'click .testconnectiontorepo': 'testConnectionToRepo',
        },
        preventform: function (e) {
            e.preventDefault();
        },
        testConnectionToRepo: function (e) {

            var $this = $(e.currentTarget);
            var that = this;
            $this.attr('data-html', $this.html()).html('<i class="fa fa-spin fa-spinner"></i>').prop('disabled', true);

            _ajax({
                url: base + 'api/deploy/getbranches',
                data: {
                    repo: $('input[name="repo"]').val(),
                    username: $('input[name="username"]').val(),
                    password: $('input[name="password"]').val(),
                },
                method: 'post',
                dataType: 'json'
            }).done(function (data) {
                console.log(data);
                if (data.status) {
                    that._branches = data.data;
                    $this.addClass('btn-success').html('<i class="fa fa-check"></i> connected').prop('disabled', true);
                    var b = '';
                    $.each(data.data, function (i, a) {
                        b += '<option value="' + a + '">' + a + '</option>';
                    });
                    $('select.repo-branches').attr('data-header', 'Got ' + data.data.length + ' branches').html(b).selectpicker('refresh');
                } else {
                    $.alert({
                        title: 'Something went wrong.',
                        icon: 'fa fa-times red',
                        content: 'We have trouble connecting to your repository,<br> Url: <code>' + escapeTag(data.request.repo) + '</code>',
                    });
                    $this.html($this.attr('data-html')).prop('disabled', false);
                }
            }).error(function () {
                $this.html($this.attr('data-html')).prop('disabled', false);
            });

        },
        priCheck: function (e) {
            var $this = $(e.currentTarget);
            if ($this.prop('checked')) {
                $('#deploy-add-privaterepo-div').show().find('input').removeAttr('disabled').attr('required', true);
            } else {
                $('#deploy-add-privaterepo-div').hide().find('input').attr('disabled', true).removeAttr('required');
            }
        },
        calcname: function (e) {
            $btn = $('.testconnectiontorepo');
            $btn.removeClass('btn-success').html($btn.attr('data-html')).prop('disabled', false);

            var $this = $(e.currentTarget);
            var str = $this.val();
            var tar = $('#deploy-save-new input[name="name"]');
            var i = str.indexOf('.git');
            if (i !== -1) {
                if (i == str.length - 4) {
                    var s = str.lastIndexOf('/');
                    var o = str.substring(s + 1, str.length - 4);
                    tar.val(o.toLowerCase());
                } else {
                    tar.val('');
                }
            } else {
                tar.val('');
            }
        },
        savenew: function (e) {
            var $this = $(e.currentTarget);
            e.preventDefault();

//            $this.attr('readonly', true);
//            $('#add-deploy-form').find('select,input').attr('readonly', true);

            var envs = [];
            $.each($('.env-rows'), function (i, a) {
                var b = $(a);

                envprop = {
                    'env_name': b.find('input[name="env_name"]').val(),
                    'env_branch': b.find('select[name="env_branch"]').val(),
                    'env_ftp': b.find('select[name="env_ftp"]').val(),
                    'env_deploy': b.find('input[name="env_deploy"]').prop('checked')
                };
                envs.push(envprop);
            });

            var data = {
                repo: $('input[name="repo"]').val(),
                name: $('input[name="name"]').val(),
                username: $('input[name="username"]').val(),
                password: $('input[name="password"]').val(),
                env: envs,
                key: $('input[name="key"]').val()
            };

            _ajax({
                url: base + 'api/deploy/new',
                data: data,
                dataType: 'json',
                method: 'post'
            }).done(function (data) {
                $this.find('select, input').removeAttr('readonly');
                data = JSON.parse(data);

                if (data.status) {

                    $.alert({
                        title: 'Added',
                        content: 'The configuration is added, please proceed for first deployment.'
                    });
//                    Router.navigate('deploy', {
//                        trigger: true
//                    });

                } else {
                    noty({
                        text: data.reason,
                        type: 'error'
                    });
                }
            });

        },
        render: function (id) {
            var that = this;

            this.$el.html(this.el = $('<div class="projectadd-wrapper bb-loading">'));
            this.page = page;
            this.template = _.template(this.page);

            _ajax({
                url: base + 'api/ftp/getall',
                dataType: 'json',
            }).done(function (data) {
                if (data.data.length == 0) {
                    $.confirm({
                        title: 'No FTP servers found.',
                        content: 'To setup a deploy, you first need to add a FTP server configuration.',
                        confirmButton: 'Add ftp',
                        confirm: function () {
                            Router.navigate('#ftp/add', {
                                trigger: true
                            });
                        },
                        confirmButtonClass: 'btn-success'
                    })
                }
                var page = that.template({'ftplist': data.data});
                that.el.html(page);
                $('.selectpicker').selectpicker();
            });
        }
    });

    return d;
});