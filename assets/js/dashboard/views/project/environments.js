define([
    'text!pages/project/environments.html',
    'utils/deployHelper',
], function (envHtml, deployHelper) {
    /**
     * Project Env.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .project-branch .start-deploy': 'deploybranchOptions',
            'click .project-branch': 'gotoManage',
            'click .env-start-deploy': 'deploybranchOptions',
        },
        deploybranchOptions: function (e) {
            e.preventDefault();
            e.stopPropagation();
            deployHelper.showOptions(this.parent.id, $(e.currentTarget).attr('data-branch'));
        },
        gotoManage: function (e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(e.currentTarget).attr('data-uri');

            Router.navigate(url, {
                trigger: true
            });
        },
        render: function (parent) {
            var that = this;
            this.parent = parent;
            $(this.parent.subPage).html('');
            that.template = _.template(envHtml);
            that.parent.getData().done(function (data) {
                var subPage = that.template({
                    data: data
                });
                $(that.parent.subPage).html(subPage);
            })
        }
    });

    return d;
});