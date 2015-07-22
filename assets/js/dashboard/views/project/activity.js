define([
    'text!pages/project/activity.html',
], function (projectActivityHtml) {
    /**
     * PROJECT LISTING.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .startdeploy': 'firstDeploy',
            'click .watchPayload': 'getPayload',
            'click .watchRawData': 'getRawData',
            'click .activity-data-records-view-more': 'renderMoreActivity',
        },
        firstDeploy: function (e) {
            var $this = $(e.currentTarget);
            var that = this;

            var p = '<i class="fa fa-spin fa-spinner fa-fw"></i> Deploy in progress';
            var f = '<i class="fa fa-coffee fa-fw"></i> Retry';

            $this.html(p);
            $this.prop('disabled', true);
            _ajax({
                url: dash_url + 'api/deploy/run/',
                data: {
                    'deploy_id': that.parent.id,
                    'type': 'sync'
                },
                method: 'post',
                dataType: 'json',
            }).done(function (data) {
                if(data.status){
                    noty({
                        text: 'Deploy added to Queued. Will be deployed shortly.',
                        type: 'success',
                    });
                    app_reload();
                }else{
                    $this.html(f).prop('disabled', false);
                }
            });
        },
        getPayload: function (e) {
            var that = this;
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');

            $.alert({
                title: 'Provided Payload.',
                content: 'url:' + base + 'api/records/getpayload/' + id,
                animation: 'top',
                confirmButton: 'Close',
                theme: 'white',
                columnClass: 'col-md-6 col-md-offset-3',
            });
        },
        getRawData: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            var that = this;

            $.alert({
                title: 'Raw Output',
                content: 'url:' + base + 'api/records/getraw/' + id,
                animation: 'top',
                confirmButton: 'Close',
                theme: 'white',
                columnClass: 'col-md-6 col-md-offset-3',
            });
        },
        renderMoreActivity: function (e) {
            e.preventDefault();
            $this = $(e.currentTarget);
            $this.attr('disabled', true);
            $this.html('<i class="fa fa-spin fa-refresh"></i> Getting activity');
            var count = $('.project-record-list').length;
            var that = this;
            _ajax({
                url: base + 'api/records/get/' + that.parent.id,
                method: 'get',
                dataType: 'json',
                data: {
                    limit: '10',
                    offset: count,
                }
            }).done(function (records) {
                that.activityData = records;
                var subPage = that.template({
                    's': that.parent.data.data[0],
                    'activity': records,
                    'more': 'true',
                    'count': records.count,
                    'renderedCount': count + 10
                });
                $this.remove();
                that.$el.find('.project-record-list-wrapper').append(subPage);
            });
        },
        render: function (parent) {
            this.parent = parent;
            var that = this;
            $(that.parent.subPage).html('');
            console.log(this.parent);

            // todo: add changing element html.

            _ajax({
                url: base + 'api/records/get/' + that.parent.id,
                method: 'get',
                dataType: 'json',
                data: {
                    limit: '10'
                }
            }).done(function (records) {
                that.activityData = records;
                that.template = _.template(projectActivityHtml);
                var subPage = that.template({
                    's': that.parent.data.data[0],
                    'activity': records,
                    'more': 'false',
                    'count': records.count,
                    'renderedCount': 10
                });
                $(that.parent.subPage).html(subPage);
            });
        }
    });

    return d;
});