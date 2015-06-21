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
                    'deploy_id': this.parent.id
                },
                method: 'post',
                dataType: 'html',
            }).done(function (data) {
                console.log(data)
            });
        },
        render: function (parent) {
            var that = this;
            this.parent = parent;
            $(this.parent.subPage).html('');
            that.template = _.template(envHtml);
            var subPage = that.template({
                data: that.parent.data
            });
            $(this.parent.subPage).html(subPage);
        }
    });

    return d;
});