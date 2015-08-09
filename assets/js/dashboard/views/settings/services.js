define([
    'text!pages/settings/services.html'
], function (page) {
    d = Backbone.View.extend({
        events: {
            'click .services-btn button': 'linkService'
        },
        linkService: function (e) {
            e.preventDefault();
            var name = $(e.currentTarget).data('name');
            window.location = home_url + 'api/user/oauth/' + name;
        },
        render: function () {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading side-anim">').addClass(viewClass()));
            this.template = _.template(page);
            setTitle('Services | Settings');
            that.$e.html(that.template());
            this.$e.find('.panel').addClass('panel-disabled panel-loading');
            this.loadContent();
        },
        loadContent: function (e) {
            var that = this;
            _ajax({
                url: base + 'api/etc/services',
                method: 'get',
                dataType: 'json',
            }).done(function (response) {
                $.each(response.data, function (i, a) {
                    var provider = a.provider.toLowerCase();
                    $('button[data-name="'+provider+'"]').prop('disabled', true);
                    // select thing here.
                });
                that.$e.find('.panel').removeClass('panel-disabled panel-loading');
            });
        },

    });
    return d;
});