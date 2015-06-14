define([
    'text!pages/projectview.html',
    'text!pages/projectActivity.html',
    'text!pages/projectSettings.html',
    'text!pages/projectEnvironments.html',
    'text!pages/projectEnvironments-manage.html',
], function (main, activityView, settingsView, environmentsView, manageenvironmentsView) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'change #doesreponeedlogin': 'inputCheckboxToggle',
            'click .startdeploy': 'deployProject',
            'click .watchRawData': 'getRawData',
            'click .watchPayload': 'getPayload',
            'click .activity-data-records-view-more': 'renderMoreActivity',
            'click .deleteproject': 'deleteProject',
            'click .project-branch button.deploy': 'deployBranch',
            'submit #deploy-view-form-edit': 'updateSettings',
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
                        content: 'Settings have been updated.<>' + data.message,
                    });
                } else {
                    noty({
                        text: data.reason
                    });
                }
            });
        },
        inputCheckboxToggle: function (e) {
            var $this = $(e.currentTarget);
            var $p = $('.privaterepo-toggle');
            if ($this.prop('checked')) {
                $p.show().find('input').removeAttr('disabled').attr('required', true);
            } else {
                $p.hide().find('input').attr('disabled', true).removeAttr('required');
            }
        },
        deployProject: function (e) {
            var $this = $(e.currentTarget);
            var that = this;

            var p = '<i class="fa fa-spin fa-spinner fa-fw"></i> Deploy in progress';
            var f = '<i class="fa fa-coffee fa-fw"></i> Retry';

            $this.html(p);
            $this.attr('disabled', true);
            _ajax({
                url: dash_url + 'api/deploy/run/',
                data: {
                    'deploy_id': this.id,
                },
                method: 'post',
                dataType: 'html',
            }).done(function (data) {
                console.log(data);
            });
            window.ajax = ajax;
        },
        getRawData: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            var that = this;

            window.$a = $.alert({
                title: 'Raw Output',
                //content: 'Raw console data is useful while debugging a problem, <br><pre>' + JSON.stringify(raw, null, 2) + '</pre>',
                content: 'url:' + base + 'api/records/getraw/' + id,
                animation: 'scale',
                confirmButton: 'Okay',
                theme: 'white'
            });
        },
        getPayload: function (e) {
            var that = this;
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');

            window.$a = $.alert({
                title: 'Provided Payload.',
                content: 'url:' + base + 'api/records/getpayload/' + id,
                animation: 'scale',
                confirmButton: 'Good',
                theme: 'white'
            });
        },
        renderMoreActivity: function (e) {
            e.preventDefault();
            $this = $(e.currentTarget);
            $this.attr('disabled', true);
            $this.html('<i class="fa fa-spin fa-refresh"></i> Getting data');
            var count = $('.project-record-list').length;
            var that = this;
            _ajax({
                url: base + 'api/records/getall/' + this.id,
                method: 'get',
                dataType: 'json',
                data: {
                    limit: '10',
                    offset: count,
                }
            }).done(function (data) {
                that.activityData = data;
                var subPage = that.template[that.which]({
                    's': that.data.data[0],
                    'activity': data,
                    'more': 'true',
                    'count': data.count,
                    'renderedCount': count + 10
                });
                $this.remove();
                $('.project-record-list-wrapper').append(subPage);
            });
        },
        deleteProject: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');

            $.confirm({
                title: 'Delete',
                content: 'Do you want to permanently delete this project and its related data?<br>' +
                'Following will not be affected: <br><br>' +
                '<ul class="bold">' +
                '<li>Your Git repository.</li>' +
                '<li>Files on FTP server.</li>' +
                '</ul>',
                theme: 'white',
                icon: 'fa fa-warning orange',
                confirmButton: 'proceed',
                confirmButtonClass: 'btn-warning',
                confirm: function () {

                    $.confirm({
                        title: 'Sure',
                        content: 'You cannot undo this action.',
                        icon: 'fa fa-info red',
                        confirmButton: 'Delete',
                        animation: 'scale',
                        confirmButtonClass: 'btn-danger',
                        autoClose: 'cancel|10000',
                        theme: 'white',
                        confirm: function () {

                            _ajax({
                                url: base + 'api/deploy/delete/' + id,
                                dataType: 'json',
                                method: 'get',
                            }).done(function (data) {

                                if (data.status) {
                                    $.alert({
                                        title: 'Deleted',
                                        content: 'The project was successfully deleted.'
                                    });
                                    Router.navigate('#/project', {
                                        trigger: true,
                                    })
                                } else {
                                    $.alert({
                                        title: 'Could not delete.',
                                        content: 'Sorry, <br><code>' + data.reason + '</code>',
                                    });
                                }
                            });
                        }
                    });
                }
            });
        },
        deployBranch: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            _ajax({
                url: dash_url + 'api/deploy/run/',
                data: {
                    'branch_id': id,
                    'deploy_id': this.id
                },
                method: 'post',
                dataType: 'html',
            }).done(function (data) {
                console.log(data)
            });

        },
        updateSettings: function (e) {
            var that = this;
            var $this = $(e.currentTarget);
            e.preventDefault();

            $this.find('select, input, button').attr('readonly', true);

            _ajax({
                url: base + 'api/deploy/edit/' + that.id,
                data: $this.serializeArray(),
                method: 'post',
                dataType: 'json',
            }).done(function (data) {
                if (data.status) {
                    $.alert({
                        title: 'Updated ' + data.request.name,
                        content: 'Respository is updated!',
                    });
                    app_reload();
                } else {
                    $.alert({
                        title: 'Something went wrong.',
                        content: data.reason
                    });
                }
            }).always(function () {
                $this.find('select, input, button').removeAttr('readonly');
            });
        },
        render: function (url) {
            var that = this;
            this.url = url;
            this.urlp = url.split('/');
            this.id = this.urlp[0];
            console.log(this.action_parts);

            // page find.
            if (this.urlp.length == 1) {
                var page = 'activity';
            } else if (this.urlp.length == 2) {
                var page = this.urlp[1];
            } else if (this.urlp.length > 2) {
                var page = this.urlp[2];
            }

            // save which page.
            this.which = page;
            console.log('page is ', page);

            var is_loaded = ($('.project-v-status').length) ? true : false;
            if (!is_loaded) {
                this.$el.html(this.el = $('<div class="projectview-wrapper bb-loading">'));
            }

            // save templates.
            this.page = {
                main: main,
                activity: activityView,
                settings: settingsView,
                environments: environmentsView,
                manage: manageenvironmentsView,
            };
            // save the compiled templates
            this.template = {
                main: _.template(this.page.main),
                activity: _.template(this.page.activity),
                settings: _.template(this.page.settings),
                environments: _.template(this.page.environments),
                manage: _.template(this.page.manage),
            };

            _ajax({
                url: base + 'api/deploy/getall/' + this.id,
                method: 'get',
                dataType: 'json'
            }).done(function (data) {
                if (data.data.length == 0) {
                    Router.navigate('#/project', {
                        trigger: true,
                        replace: true,
                    });
                    return false;
                }
                var template = that.template.main({
                    's': data.data[0],
                    'v': that.which
                });
                that.data = data;

                if(is_loaded){
                    that.el.html(template);
                }else{
                    var $el2 = $('<div class="projectview-anim">');
                    that.el.html($el2);
                    that.el = $el2;
                    $el2.html(template);
                }

                that.renderChild();
            });

        },
        _activity: function () {
            var that = this;
            _ajax({
                url: base + 'api/records/getall/' + this.id,
                method: 'get',
                dataType: 'json',
                data: {
                    limit: '10'
                }
            }).done(function (data) {
                that.activityData = data;
                var subPage = that.template[that.which]({
                    's': that.data.data[0],
                    'activity': data,
                    'more': 'false',
                    'count': data.count,
                    'renderedCount': 10
                });
                $('.deploy-sub-page').html('');
                $('.deploy-sub-page').html(subPage);
            });
        },
        _settings: function () {
            var that = this;

            var subPage = that.template[that.which]({
                data: that.data.data[0],
            });
            $('.deploy-sub-page').html('');
            $('.deploy-sub-page').html(subPage);

        },
        _environments: function () {
            var that = this;
            var subPage = that.template[that.which]({
                data: that.data
            });

            $('.deploy-sub-page').html('');
            $('.deploy-sub-page').html(subPage);
        },
        _manage: function () {
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
            $('.deploy-sub-page').html('');

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

                var subPage = that.template[that.which]({
                    data: that.data.data[0],
                    branch: branch[0],
                    ftp: ftpdata.data[0],
                    ftplist: ftplist,
                });
                $('.deploy-sub-page').html('');
                $('.deploy-sub-page').html(subPage);
            })

        },
        renderChild: function () {
            var that = this;
            if (typeof this['_' + this.which] == 'function') {
                this['_' + this.which]();
            } else {
                console.log('404: page not found');
            }
        },
    })
    ;
    return d;
})
;