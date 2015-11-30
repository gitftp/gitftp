define([
    'text!pages/project/activity.html',
], function (projectActivityHtml) {
    /**
     * PROJECT LISTING.
     */
    d = Backbone.View.extend({
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
                    'deploy_id': that.id,
                    'type': 'sync'
                },
                method: 'post',
                dataType: 'json'
            }).done(function (data) {
                if (data.status) {
                    noty({
                        text: 'Deploy added to Queued. Will be deployed shortly.',
                        type: 'success'
                    });
                    app_reload();
                } else {
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
                closeIcon: true,
                content: function () {
                    var o = this;
                    return _ajax({
                        url: base + 'api/records/payload/' + id,
                        method: 'get',
                        dataType: 'json'
                    }).done(function (response) {
                        o.contentDiv.html(response.data);
                    });
                },
                confirmButton: 'Close',
                theme: 'white',
                columnClass: 'col-md-12 col-md-offset-',
                animation: 'top',
                closeAnimation: 'top',
            });
        },
        getRawData: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            var that = this;

            $.alert({
                title: 'Raw Output',
                closeIcon: true,
                content: function () {
                    var o = this;
                    return _ajax({
                        url: base + 'api/records/raw/' + id,
                        method: 'get',
                        dataType: 'json'
                    }).done(function (response) {
                        o.contentDiv.html(response.data);
                    })
                },
                confirmButton: 'Close',
                theme: 'black',
                columnClass: 'col-md-6 col-md-offset-3',
                animation: 'top',
                closeAnimation: 'top',
            });
        },
        renderMoreActivity: function (e) {
            e.preventDefault();
            var that = this;
            var $this = $(e.currentTarget);
            $this.attr('disabled', true);
            $this.html('<i class="fa fa-spin fa-refresh"></i> Getting activity');
            var offset = $('.project-record-list').length;
            this.getRecords(offset).done(function (records) {
                that.activityData = records;
                var subPage = that.template({
                    'data': that.data.data[0],
                    'activity': records,
                    'more': 'true',
                    'count': records.count,
                    'renderedCount': offset + 10
                });
                $this.remove();
                that.$e.find('.project-record-list-wrapper').append(subPage);
            });
        },
        initialize: function () {
            this.template = _.template(projectActivityHtml);
        },
        getRecords: function (offset) {
            if (typeof offset == 'undefined')
                offset = 0;

            return _ajax({
                url: base + 'api/records/get/' + this.id,
                method: 'get',
                dataType: 'json',
                data: {
                    limit: '10',
                    offset: offset,
                }
            });
        },
        getData: function () {
            return _ajax({
                url: base + 'api/deploy/only/' + this.id,
                method: 'get',
                dataType: 'json',
                data: {
                    select: 'id,cloned'
                }
            });
        },
        render: function (id) {
            this.id = id;
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading project-activity-anim">').addClass(viewClass()));

            $.when(this.getRecords(), this.getData()).then(function (records, data) {
                records = records[0];
                data = data[0];
                console.log('loading');
                that.activityData = records;
                that.data = data;

                var subPage = that.template({
                    'data': data.data[0],
                    'activity': records,
                    'more': 'false',
                    'count': records.count,
                    'renderedCount': 10
                });
                that.$e.html(subPage);
                console.log('loaded');
            });
            setTitle('Activity | Projects');
        }
    });

    return d;
});