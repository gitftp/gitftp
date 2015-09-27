define([], function () {

    var process = {
        process_id: 0,
        deployView: function (e) {
            /*
             * Project view page.
             */
            var that = this;
            setTimeout(function () {
                if ($('.is-deploy-view-id').length) {
                    var id = $('.is-deploy-view-id').attr('data-id');

                    _ajax({
                        url: base + 'api/deploy/get/' + id,
                        method: 'get',
                        dataType: 'json',
                    }).done(function (response) {
                        if (response.status && response.data.length) {
                            data = response.data[0];
                            var el = $('.project-v-status');
                            if (data.status == 'Idle' || data.status == 'To be initialized') {
                                el.removeClass("project-co-loading");
                                el.html(data.status);
                            } else {
                                el.addClass("project-co-loading");
                                el.html('<i class="fa fa-spin fa-refresh fa-fw"></i> ' + data.status);
                            }
                        }
                    });
                }
                if ($('.is-deploy-list').length) {
                    _ajax({
                        url: base + 'api/deploy/only/',
                        data: {
                            select: 'id'
                        },
                        method: 'get',
                        dataType: 'json'
                    }).done(function (response) {
                        if (response.status && response.data.length) {
                            $.each(response.data, function (i, a) {
                                $target = $('.is-deploy-list[data-id="' + a.id + '"]');
                                $target.find('.status').html('(' + a.status + ')');
                            });
                        }
                    });
                }
                that.deployView();
            }, this.deployViewInterval);
        },
        deployViewInterval: 10000,
        timeUpdateInterval: 500,
        timeUpdate: function () {
            /*
             * Time update . class name: .dynamicTime
             */
            var that = this;
            setTimeout(function () {
                if ($('.dynamicTime').length) {
                    $('.dynamicTime').each(function (i, a) {
                        var $this = $(this);
                        var timestamp = (new Date(parseInt($this.attr('data-timestamp')) * 1000)).getTime();
                        var currtime = parseInt((new Date()).getTime().toString());
                        var diff = currtime - timestamp;
                        $this.html(moment.duration(diff).humanize() + ' ago');
                    });
                }
                that.timeUpdate();
                if (this.timeUpdateInterval == 1) {
                    this.timeUpdateInterval = 10000;
                }
            }, this.timeUpdateInterval);

        },
        runProcess: function () {
            this.deployView();
            this.timeUpdate();
        },
        init: function () {
            this.runProcess();
        }
    };


    return process;
});
        