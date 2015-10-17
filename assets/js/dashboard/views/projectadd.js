define([
    'text!pages/project-add/main.html',
    'text!pages/project-add/env-add.html',
], function (page, env_add) {

    return Backbone.View.extend({
        el: app.el,
        events: {
            'change #add-repo-from-service': 'manualswitch',
            'click #deploy-save-new': 'save',
            'submit #add-deploy-form, .env-form': 'preventform',
            'input input#add-repo': 'calcname',
            'change #deploy-add-privaterepo': 'priCheck',
            'click #project-add-add-env': 'addEnv',
            'click .project-add-remove-env': 'removeEnv',
            'change .env_ftp': 'updateFtpOptions'
        },
        manualswitch: function (e) {
            var $this = $(e.currentTarget);
            options = {
                queue: false,
                speed: 100,
                easing: 'easeOutQuart'
            };
            if ($this.prop('checked')) {
                $('#add-repo-service').prop('disabled', true);
                $('.manual-project').slideDown(options);
                $('.service-project').slideUp(options);
            } else {
                $('#add-repo-service').prop('disabled', false);
                $('.manual-project').slideUp(options);
                $('.service-project').slideDown(options);
            }
        },
        preventform: function (e) {
            e.preventDefault();
        },
        getBranches: function () {
            var that = this;
            if ($('input#add-repo-from-service').length && !$('input#add-repo-from-service').is(':checked')) {
                var id = $('#add-repo-service').val();
                var selected = _.filter(this._repo.data, function (num) {
                    return num.id == id;
                });
                console.log('all: ', this._repo.data);
                console.log('selected: ', selected);
                console.log('selected count. ', selected.length);
                if (!selected.length) {
                    $.alert({
                        title: "Problem",
                        content: 'Something went wrong. please try again later.'
                    });
                    return false;
                } else {
                    selected = selected[0];
                }
                that.selectedRepo = selected; // for use later.
                var data = {
                    type: 'service',
                    repo: selected.clone_url,
                    name: selected.name,
                    provider: selected.provider
                }
            } else {
                var data = {
                    type: 'manual',
                    repo: $('input[name="repo"]').val(),
                    username: $('input[name="username"]').val(),
                    password: $('input[name="password"]').val()
                };
            }

            return _ajax({
                url: base + 'api/etc/getremotebranches',
                data: data,
                method: 'post',
                dataType: 'json'
            });
        },
        priCheck: function (e) {
            var $this = $(e.currentTarget);
            var options = {
                queue: false,
                speed: 100,
                easing: 'easeOutQuart'
            };
            if ($this.prop('checked')) {
                $('#deploy-add-privaterepo-div').slideDown(options).find('input').removeAttr('disabled');
            } else {
                $('#deploy-add-privaterepo-div').slideUp(options).find('input').attr('disabled', true);
            }
        },
        calcname: function (e) {
            var $this = $(e.currentTarget);
            var str = $this.val();
            var tar = $('input[name="name"]#name');
            if (tar.val().trim() !== '') {
                return false;
            }
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
        save: function (e) {
            var $this = $(e.currentTarget);
            e.preventDefault();
            var that = this;
            var valid = true;
            var $form = $('#add-deploy-form-step1');
            if (!$form.valid()) {
                valid = false;
            }
            if (this.envforms.length == 0 && valid) {
                $form.submit();
                return false;
            }
            $.each(this.envforms, function (i, a) {
                if (!a.el.valid())
                    valid = false;
            });
            if (!valid)
                return false;

            // gathering env data.
            var envs = [];
            $.each($('.env-div'), function (i, a) {
                var b = $(a);
                envprop = {
                    'env_name': b.find('input[name="env_name"]').val(),
                    'env_branch': b.find('select[name="env_branch"]').val(),
                    'env_ftp': b.find('select[name="env_ftp"]').val(),
                    'env_deploy': b.find('input[name="env_deploy"]').prop('checked'),
                    'env_deploy_now': b.find('input[name="env_deploy_now"]').prop('checked')
                };
                envs.push(envprop);
            });

            // determine if service or manual.
            if ($('input#add-repo-from-service').length && !$('input#add-repo-from-service').is(':checked')) {
                var selected = that.selectedRepo;
                var data = {
                    type: 'service',
                    repo: selected.clone_url,
                    name: $('input[name="name"]').val(),
                    env: envs,
                    gitname: selected.name,
                    gitid: selected.id,
                    key: $('input[name="key"]').val() || '',
                    provider: selected.provider
                };
            } else {
                var data = {
                    type: 'manual',
                    repo: $('input[name="repo"]').val(),
                    name: $('input[name="name"]').val(),
                    username: $('input[name="username"]').val(),
                    password: $('input[name="password"]').val(),
                    env: envs,
                    key: $('input[name="key"]').val() || ''
                };
            }

            $this.html('<i class="gf gf-loading gf-btn"></i> Adding').prop('disalbed', true);
            this.togglePanel(1, 'disable');
            this.togglePanel(2, 'disable');
            _ajax({
                url: base + 'api/deploy/create',
                data: data,
                dataType: 'json',
                method: 'post'
            }).done(function (data) {
                if (data.status) {
                    $.alert({
                        title: 'Added',
                        icon: 'fa fa-check green',
                        content: 'Your project has been successfully created.',
                        confirmButton: 'close'
                    });
                    Router.navigate('/project', {
                        trigger: true
                    });
                } else {
                    $.alert({
                        title: 'Problem',
                        content: data.reason,
                        icon: 'fa fa-info red'
                    });
                }
            }).always(function () {
                $this.html('Save').prop('disalbed', false);
                that.togglePanel(1, 'enable');
                that.togglePanel(2, 'enable');
            });
        },
        togglePanel: function (which, action) {
            var $panel = $('.panel-step-' + which);
            if (action == 'disable') {
                $panel.addClass('panel-disabled').find(':input').attr('readonly', 'readonly')
                    .end().find('button').attr('disabled', 'disabled');
            } else {
                $panel.removeClass('panel-disabled').find(':input').removeAttr('readonly')
                    .end().find('button').removeAttr('disabled');
            }
        },
        removeEnv: function (e) {
            e.preventDefault();
            var that = this;
            var $this = $(e.currentTarget);
            if ($('.env-div').length <= 1) {
                noty({
                    text: 'Project must have atleast one environment',
                    type: 'error'
                });
                return false;
            } else {
                var id = $this.parents('.env-div').attr('data-id');
                console.log(this.envforms);
                $.each(this.envforms, function (i, a) {
                    console.log(a, id);
                    if (a.id == id) {
                        that.envforms.splice(i, 1);
                        $this.parents('.env-div').remove();
                        return false;
                    }
                });
                console.log(this.envforms)
            }
            this.updateFtpOptions();
        },
        updateFtpOptions: function () {
            var selected = this.getselectedFtp();
            var $options = $('select[name="env_ftp"] option');
            $.each($options, function (i, a) {
                var $a = $(a);
                if (!$a.is(':selected')) {
                    if (_.indexOf(selected, $a.val()) >= 0) {
                        $a.attr('disabled', 'disabled');
                    } else {
                        $a.removeAttr('disabled');
                    }
                }
            });
            //$('select[name="env_ftp"]').selectpicker('render');
        },
        envforms: [],
        getselectedFtp: function () {
            var selectedFtps = [];
            $.each($('select[name="env_ftp"]'), function (i, a) {
                $a = $(a);
                selectedFtps.push($a.val());
            });
            return _.compact(selectedFtps);
        },
        addEnv: function () {
            var random = _.uniqueId();
            var that = this;

            var selected = this.getselectedFtp();

            if (selected.length == this._ftps.length) {
                noty({
                    text: 'Not enough FTP servers. please add new FTP servers to deploy on. <br>' +
                    '<i class="fa fa-warning"></i> You cannot deploy multiple projects/branches in one FTP server',
                    type: 'error'
                });
                return false;
            }

            var ct = this.env_template({
                'random': random,
                'ftplist': this._ftps,
                'branches': this._branches,
                'that': this
            });
            if ($('.env-div').length == 0) {
                $('.env-table').html(ct);
            } else {
                $('.env-table').append(ct);
            }
            this.envforms.push({
                id: random,
                el: $('.env-form-' + random)
            });
            $('.env-form-' + random).find('[name="env_ftp"]').on('change', function () {
                that.updateFtpOptions();
            });
            //.selectpicker().end().find('[name="env_branch"]').selectpicker();

            that.updateFtpOptions();
            $('.env-form-' + random).validate({
                debug: true,
                submitHandler: function () {
                },
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    'env_name': {
                        required: true
                    },
                    'env_branch': {
                        required: true
                    },
                    'env_ftp': {
                        required: true
                    },
                }
            });
        },
        validation: function () {
            var that = this;
            $('#add-deploy-form-step1').validate({
                debug: true,
                submitHandler: function (form) {
                    that.togglePanel(1, 'disable');
                    var $l = $.dialog({
                        title: 'Connecting...',
                        icon: 'gf gf-loading gf-block gf-alert',
                        content: 'Please wait while we fetch available branches on your repository.',
                        backgroundDismiss: false,
                        closeIcon: false
                    });
                    that.getBranches().done(function (data) {
                        console.log(data);
                        if (data.status) {
                            that.togglePanel(1, 'disable');
                            that.togglePanel(2, 'enable');
                            that._branches = data.data;
                            that.addEnv();
                        } else {
                            noty({
                                text: '<i class="fa fa-warning"></i>&nbsp; ' + data.reason,
                                type: 'error'
                            });
                            that.togglePanel(1, 'enable');
                        }
                    }).fail(function () {
                        that.togglePanel(1, 'enable');
                        that.togglePanel(2, 'disable');
                    }).always(function () {
                        $l.close();
                    });

                    return false;
                },
                errorClass: 'error',
                rules: {
                    'name': {
                        required: true
                    },
                    'repo': {
                        required: true,
                        url: true
                    },
                    'username': {
                        required: {
                            depends: function () {
                                return $('input[name="isprivate"]').is(':checked');
                            }
                        }
                    },
                    'password': {
                        required: false
                    },
                    'key': {
                        required: false
                    }
                }
            });
        },
        render: function (id) {
            var that = this;
            this.$el.html(this.el = $('<div class="bb-loading">').addClass(viewClass()));
            this.page = page;
            this.template = _.template(this.page);
            this.env_page = env_add;
            this.env_template = _.template(this.env_page);
            var $getftp = _ajax({
                url: base + 'api/ftp/unused',
                dataType: 'json',
                method: 'get'
            });
            var $getlimit = _ajax({
                url: base + 'api/deploy/limit',
                dataType: 'json',
                method: 'get'
            });
            var $getrepositories = _ajax({
                url: base + 'api/git/repositories',
                dataType: 'json',
                method: 'get'
            });

            var $l = $.dialog({
                title: 'Getting repositories..',
                //icon: 'fa fa-spinner fa-spin',
                icon: 'gf gf-loading gf-block gf-alert',
                content: 'Please wait, while we fetch data from services.',
                backgroundDismiss: false,
                closeIcon: false,
                container: that.el,
                animation: 'scale',
                animationBounce: 1.5
            });

            $.when($getftp, $getlimit, $getrepositories).then(function (ftp, limit, repo) {
                $l.close();
                var data = ftp[0];
                var limit = limit[0];
                var repo = repo[0];
                that._repo = repo;
                that._ftps = data.data;
                that._repoGrouped = _.groupBy(repo.data, function (a) {
                    return a.provider
                });
                var page = that.template({
                    repo: repo,
                    repogrouped: that._repoGrouped
                });
                that.el.html(page);
                that.validation();
                $('.boot-select').select2({
                    placeholder: 'Select repository'
                });
                $('input[name="name"]').focus();
                if (limit.data.projects >= limit.data.limit) {
                    $.alert({
                        title: 'Limit reached!',
                        icon: 'fa fa-warning orange',
                        content: 'Sorry, you\'ve hit maximum project limit on gitftp. Cannot create new project.',
                        backgroundDismiss: false,
                        closeIcon: false,
                        confirmButton: '<i class="fa fa-arrow-left"></i>&nbsp; Back',
                        confirm: function () {
                            window.history.back();
                        },
                        container: that.el
                    });
                    return false;
                }
                if (data.data.length == 0) {
                    $.confirm({
                        title: 'No FTP servers',
                        icon: 'fa fa-info',
                        content: 'You\'ve no available FTP servers ready to Link with your new project. Please create one.',
                        cancelButton: 'Add ftp',
                        cancel: function () {
                            Router.navigate('/ftp/add', {
                                trigger: true
                            });
                        },
                        confirmButton: '<i class="fa fa-arrow-left"></i>&nbsp; Back',
                        confirm: function () {
                            window.history.back();
                        },
                        confirmButtonClass: 'btn-default',
                        cancelButtonClass: 'btn-success',
                        backgroundDismiss: false,
                        container: that.el
                    });
                }
            }).fail(function () {
                $l.close();
                $.confirm({
                    title: 'Problem',
                    content: 'We faced a problem while fetching ',
                    confirm: function () {
                        app_reload();
                    },
                    confirmButton: 'Retry',
                    cancelButton: 'Close',
                    cancel: function () {
                        Router.navigate('project', {
                            trigger: true,
                            replace: true
                        });
                    }
                });
            });
            setTitle('New project');
        }
    });
});