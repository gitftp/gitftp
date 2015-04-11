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
                el.html(data.status);
                if()
                el.addClass("project-co-loading");
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
        