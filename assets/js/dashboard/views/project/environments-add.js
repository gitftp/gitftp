define([
    'text!pages/project/environments-add.html',
], function (envHtml) {
    /**
     * Project Env add.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {},
        render: function () {
            var that = this;
            var deploy = that.data.data[0];

            that.template = _.template(envHtml)
            var subPage = that.template({
                data: that.data,
            });

            $('.deploy-sub-page').html('');
            $('.deploy-sub-page').html(subPage);

            _ajax({
                url: dash_url + 'api/deploy/getbranches',
                data: {
                    'deploy_id': deploy.id
                },
                method: 'post',
                dataType: 'json'
            }).done(function (branches) {

            });
        }
    });

    return d;
});