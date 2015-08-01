define([
    'text!pages/dashboard.html'
], function (page) {
    d = Backbone.View.extend({
        el: app.el,
        render: function (id) {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));

            this.template = _.template(page);

            _ajax({
                url: base + 'api/etc/dashboard',
                method: 'get',
                dataType: 'json'
            }).done(function (data) {
                var ctemplate = that.template({data: data.data});
                that.$e.html(ctemplate);
                that.renderStats();
            });
            setTitle('Dashboard');
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