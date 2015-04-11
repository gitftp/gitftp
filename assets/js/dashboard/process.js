define([
], function () {

    var process = {
        process_id: 0,
        deployView: function (e) {
            var that = this;
            /*
             * Project view page.
             */
            var id = $('.is-deploy-view-id').attr('data-id');

            $.getJSON(base + 'api/deploy/getall/' + id, function (data) {
                data = data.data[0];
                var el = $('.project-v-status');
                if(data.status == 'Idle' || data.status == 'to be initialized'){
                    el.removeClass("project-co-loading");
                    el.html(data.status);
                }else{
                    el.addClass("project-co-loading");
                    el.html('<i class="fa fa-spin fa-refresh fa-fw"></i> '+data.status);
                }
            });
        },
        runProcess: function () {
            var that = this;
            this.process_id = setTimeout(function () {

                if ($('.is-deploy-view-id').length) {
                    that.deployView();
                }

                that.runProcess();
            }, 1500);
        },
        init: function () {
            this.runProcess();
        }
    };


    return process;
});
        