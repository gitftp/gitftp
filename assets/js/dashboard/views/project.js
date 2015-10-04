define([
    'text!pages/project.html'
], function (page) {

    /**
     * PROJECT LISTING.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .viewdeploy': 'goto',
            'click #new-project': 'new'
        },
        new: function (e) {
            //var $this = $(e.currentTarget);
            //var plus = $this.html();
            //$this.html('<i class="fa fa-spin fa-spinner"></i>');
        },
        goto: function (e) {
            var $this = $(e.currentTarget);
            Router.navigate('/project/' + $this.attr('data-id'), {trigger: true});
        },
        render: function (id) {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));
            this.page = page;
            this.template = _.template(this.page);

            //.
            //done(function (data) {
            //    var ctemplate = that.template({data: data.data});
            //    that.$e.html(ctemplate);
            //    that.renderStats();
            //});

            $.when(_ajax({
                url: base + 'api/etc/dashboard',
                method: 'get',
                dataType: 'json'
            }), _ajax({
                url: base + 'api/deploy/only',
                dataType: 'json',
                method: 'get',
                data: {
                    select: 'id,created_at,name,repository,git_name,active'
                }
            })).then(function (dash, data) {
                dash = dash[0];
                data = data[0];
                var template = that.template({
                    'data' : dash.data,
                    'list': data.data
                });
                that.$e.html(template);
                that.renderStats();
            });
            setTitle('Projects');
        },
        renderStats: function () {
            var $panel = this.$e.find('.panel-stats');

            _ajax({
                url: base + 'api/etc/dashboard/stats',
                method: 'get',
                dataType: 'json'
            }).done(function (response) {
                $panel.find('.deploy_stats').html(response.data.projects + '/' + response.data.projects_limit);
                $panel.find('.activity_count').html(response.data.deploy_count);
                $panel.find('.data_deployed').html(response.data.deployed_data);
                $panel.removeClass('panel-loading panel-disabled');
            });
        }
    });

    return d;
});