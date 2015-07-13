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
            'click .project-branch .start-deploy': 'deployBranch',
            'click .project-branch': 'gotoManage',
            'click .env-start-deploy': 'deploybranchOptions',
        },
        deploybranchOptions: function(e){
            e.preventDefault();
            e.stopPropagation();
            deployHelper.showOptions(this.parent.id, $(e.currentTarget).attr('data-branch'));
        },
        gotoManage: function(e){
            e.preventDefault();
            e.stopPropagation();
            var url = $(e.currentTarget).attr('data-uri');

            Router.navigate(url, {
                trigger: true
            });
        },
        deployBranch: function (e) {
            e.stopPropagation();
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
                dataType: 'json',
            }).done(function (data) {
                if(data.status){
                    noty({
                        text: '<i class="fa fa-check fa-2x"></i>&nbsp; Deploy is Queued, will be processed shortly.',
                        type: 'information'
                    });
                }else{
                    noty({
                        text: data.reason,
                        type: 'error'
                    });
                }
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