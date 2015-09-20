define([
    'text!pages/settings/services.html'
], function (page) {
    d = Backbone.View.extend({
        events: {
            'click .linkService': 'linkService',
            'click .unlinkService': 'unlinkService'
        },
        linkService: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var name = $this.data('name');
            $this.html('<i class="gf gf-loading"></i> Connecting');
            window.location = home_url + 'api/user/authorize/' + name;
        },
        unlinkService: function (e) {
            e.preventDefault();
            var name = $(e.currentTarget).data('name');

            _ajax({
                url: base + 'api/etc/unlink',
                method: 'get',
                data: {
                    provider: name
                },
                dataType: 'json'
            }).done(function (response) {
                app_reload();
            });
        },
        render: function () {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading side-anim">').addClass(viewClass()));
            this.template = _.template(page);
            setTitle('Services | Settings');

            _ajax({
                url: base + 'api/etc/services',
                method: 'get',
                dataType: 'json',
            }).done(function (response) {
                that.$e.html(that.template({
                    'service': response.data
                }));
            });
        }
    });
    return d;
});