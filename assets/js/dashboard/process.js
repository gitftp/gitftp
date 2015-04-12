define([
], function () {

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
                    $.getJSON(base + 'api/deploy/getall/' + id, function (data) {
                        data = data.data[0];
                        var el = $('.project-v-status');
                        if (data.status == 'Idle' || data.status == 'to be initialized') {
                            el.removeClass("project-co-loading");
                            el.html(data.status);
                        } else {
                            el.addClass("project-co-loading");
                            el.html('<i class="fa fa-spin fa-refresh fa-fw"></i> ' + data.status);
                        }
                    });
                }
                that.deployView();
            }, 1500);
        },
        timeUpdate: function(){
            /*
             * Time update . class name: .dynamicTime
             */
            var that = this;
            setTimeout(function(){
                if($('.dynamicTime').length){
                    
                    $('.dynamicTime').each(function(i, a){
                        var $this = $(this);
                        var timestamp = (new Date(parseInt($this.attr('data-timestamp'))*1000)).getTime();
                        var diff = parseInt((new Date()).getTime().toString().substr(0, 10))-timestamp;
//                        var timeec = (new Date()).getTime()-timestamp;
                        $this.html(moment.duration(diff).humanize());
                    });
                    
                }
                that.timeUpdate();
            }, 1000);
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
        