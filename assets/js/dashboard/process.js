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
                console.log('here', data);
                data = data.data[0];
                $('.project-v-status').html(data.status);
                that.updateView();
            });
        },
        updateViewProcess: function (id) {
            var that = this;

        },
        runProcess: function () {
            var that = this;
            this.process_id = setTimeout(function () {
                
                
                if ($('.is-deploy-view-id').length) {
                    
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
        