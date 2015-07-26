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
            deployHelper.showOptions(this.id, $(e.currentTarget).attr('data-branch'));
        },
        gotoManage: function (e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(e.currentTarget).attr('data-uri');

            Router.navigate(url, {
                trigger: true
            });
        },
        initialize: function () {
            this.template = _.template(envHtml);
        },
        render: function (id) {
            var that = this;
            this.id = id;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));

            _ajax({
                url: base + 'api/branch/get',
                data: {
                    deploy_id: id
                },
                method: 'get',
                dataType: 'json',
            }).done(function (response) {
                var subPage = that.template({
                    branches: response.data,
                    deployid: id,
                });
                that.$e.html(subPage);
            })
        }
    });

    return d;
});