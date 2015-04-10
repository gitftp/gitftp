define([
], function () {


    var process = {
        process_id: 0,
        updateView: function (e) {
            var that = this;
            if ($('.is-deploy-view-id').length) {
                var id = $('.is-deploy-view-id').attr('data-id');
                setTimeout(function () {
                    that.updateViewProcess(id);
                }, 1500);
            } else {

            }
        },
        updateViewProcess: function (id) {
            var that = this;

            $.getJSON(base + 'api/deploy/getall/' + id, function (data) {
                console.log('here', data);
                data = data.data[0];
                $('.project-v-status').html(data.status);
                that.updateView();
            });
        },
        runProcess: function(){
            
        },
        init: function(){
            this.runProcess();
        }
    };


    return process;
});
        