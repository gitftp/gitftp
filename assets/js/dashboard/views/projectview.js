define([
    'text!pages/projectview.html',
    'text!pages/projectActivity.html',
    'text!pages/projectSettings.html',
], function (main, activityView, settingsView) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .startdeploy': 'startDeploy',
            'change #deploy-add-privaterepo': 'priCheck',
            'click .watchRawData': 'getRawData',
            'submit #deploy-view-form-edit': 'editConfiguration',
            'click .activity-data-records-view-more': 'renderMoreActivity'
        },
        editConfiguration: function (e) {
            var that = this;
            var $this = $(e.currentTarget);
            e.preventDefault();

            $this.find('select, input, button').attr('readonly', true);
            $.post(base + 'api/deploy/edit/' + that.id, $this.serializeArray(), function (data) {
                $this.find('select, input, button').removeAttr('readonly');
                try {
                    data = JSON.parse(data);
                } catch (e) {
                    noty({
                        text: 'something bad happened'
                    });
                }

                if (data.status) {
                    $.alert({
                        title: 'Updated! ' + data.request.name,
                        content: 'The configuration was updated.'
                    });
                    Backbone.history.loadUrl();
                } else {
                    noty({
                        text: data.reason,
                        type: 'error'
                    });
                }
            });
        },
        getRawData: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            var that = this;
            console.log(that.activityData.data);
            var raw = that.activityData.data;

            $.each(that.activityData.data, function (i, a) {
                if (a.id == id) {
                    raw = a.raw;
                }
            });
            console.log(raw);
            window.$a = $.alert({
                title: 'Raw Output',
                content: 'Raw console data is useful while debugging a problem, <br><pre>' + JSON.stringify(raw, null, 2) + '</pre>',
                animation: 'scale',
                confirmButton: 'Amazing!'
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
        render: function (id, which) {

            var that = this;
            if (which == null) {
                this.which = 'activity';
            } else {
                this.which = which;
            }

            this.page = {
                main: main,
                activity: activityView,
                settings: settingsView,
            };
            if (!$('.project-v-status').length) {
                that.$el.html('');
            }

            this.template = {
                main: _.template(this.page.main),
                activity: _.template(this.page.activity),
                settings: _.template(this.page.settings)
            };
            this.id = id;

            _ajax({
                url: base + 'api/deploy/getall/' + id,
                method: 'get',
                dataType: 'json'
            }).done(function (data) {

                if (data.data.length == 0) {
                    Router.navigate('#deploy', {
                        trigger: true
                    });
                    return false;
                }

                var template = that.template.main({'s': data.data[0], 'v': that.which});
                that.data = data;
                that.$el.html(template);
                that.renderChild();
            });
        },
        renderChild: function () {
            var that = this;
            if (this.which == 'activity') {

                _ajax({
                    url: base + 'api/records/getall/' + this.id,
                    method: 'get',
                    dataType: 'json',
                    data: {
                        limit: '10'
                    }
                }).done(function (data) {
                    that.activityData = data;
                    console.log(that.template);
                    var subPage = that.template[that.which]({
                        's': that.data.data[0],
                        'activity': data,
                        'more': 'false',
                        'count': data.count,
                        'renderedCount': 10
                    });
                    $('.deploy-sub-page').html(subPage);
                });

            }
            if (this.which == 'settings') {
                $.getJSON(base + 'api/ftp/getall', function (data) {
                    var subPage = that.template[that.which]({
                        's': that.data.data[0],
                        'ftplist': data.data
                    });
                    $('.deploy-sub-page').html(subPage);
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 500);
                });
            }
        },
        renderMoreActivity: function () {
            var count = $('tr.activity-data-records').length;
            
            _ajax({
                url: base + 'api/records/getall/' + this.id,
                method: 'get',
                dataType: 'json',
                data: {
                    limit: '10'
                }
            }).done(function (data) {
                that.activityData = data;
                console.log(that.template);
                var subPage = that.template[that.which]({
                    's': that.data.data[0],
                    'activity': data,
                    'more': 'false',
                    'count': data.count,
                    'renderedCount': 10
                });
                $('.deploy-sub-page').html(subPage);
            });
        },
        startDeploy: function (e) {
            var $this = $(e.currentTarget);
            var that = this;

            var p = '<i class="fa fa-spin fa-spinner fa-fw"></i> Deploy in progress';
            var f = '<i class="fa fa-coffee fa-fw"></i> Retry';

            $this.html(p);
            $this.attr('disabled', true);
            $.getJSON(base + 'api/deploy/start/' + this.id, function (data) {
                if (data.status) {
                    $.alert({
                        title: 'Deploy complete!',
                        content: 'Your repository files are successfully deployed.<br>Don\'t forget to add the <b>POST hook</b> to your git host provider.'
                    });
                    Backbone.history.loadUrl();
                } else {
                    $.alert({
                        title: 'Problem',
                        content: data.reason
                    });
                    $this.html(f);
                    $this.removeAttr('disabled');
                }
            });
        }
    });
    return d;
});