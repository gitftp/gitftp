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
            'submit #deploy-view-form-edit': 'editConfiguration'
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
        process_id: 0,
        updateView: function (e) {
            var that = this;
            if ($('.is-deploy-view-id').length) {
                var id = $('.is-deploy-view-id').attr('data-id');
                this.updateViewProcess(id);
            } else {
                
            }
        },
        updateViewProcess: function (id) {
            var that = this;
            
            $.getJSON(base + 'api/deploy/getall/' + id, function (data) {
                console.log('here', data);
                data = data.data[0];
                $('.project-v-status').html(data.status);
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
                content: '<pre>' + JSON.stringify(raw, null, 2) + '</pre>',
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
            $.getJSON(base + 'api/deploy/getall/' + id, function (data) {
                var template = that.template.main({'s': data.data[0], 'v': that.which});
                that.data = data;
                that.$el.html(template);
                that.renderChild();
                that.updateView();
            });
        },
        renderChild: function () {
            var that = this;
            if (this.which == 'activity') {
                $.getJSON(base + 'api/records/getall/' + this.id, function (data) {
                    that.activityData = data;
                    var subPage = that.template[that.which]({
                        's': that.data.data[0],
                        'activity': data
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
                        title: 'Woohoo!',
                        content: 'Your repository is deployed for the first time !, Cheers'
                    });
                    Backbone.history.loadUrl();
                } else {
                    $.alert({
                        title: 'Problem',
                        content: 'There was a problem. RUN FOR YOUR LIFE!!!!'
                    });
                    $this.html(f);
                }
            });
        }
    });
    return d;
});