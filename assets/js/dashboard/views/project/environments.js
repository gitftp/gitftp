define([
    'text!pages/project/environments.html',
], function (envHtml) {
    /**
     * Project Env.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .project-branch button.deploy': 'deployBranch',
        },
        deployBranch: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');
            _ajax({
                url: dash_url + 'api/deploy/run/',
                data: {
                    'branch_id': id,
                    'deploy_id': this.id
                },
                method: 'post',
                dataType: 'html',
            }).done(function (data) {
                console.log(data)
            });
        },
        render: function () {
            var that = this;
            that.template = _.template(envHtml);
            var subPage = that.template({
                data: that.data,
            });

            $('.deploy-sub-page').html(subPage);
        }
    });

    return d;
});