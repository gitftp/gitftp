define([
    'text!pages/settings/settings.html',
    'views/settings/account',
    'views/settings/notification',
    'views/settings/services',
    'views/settings/hooks',
    'views/settings/projects',
], function (page, accountView, notificationView, servicesView, hooksView, projectView) {
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .settings-panel-nav a': 'navigation'
        },
        render: function (id) {
            var that = this;
            setTitle('Settings');
            this.$el.html(this.el = $('<div class="bb-loading">').addClass(viewClass()));
            this.template = _.template(page);
            that.el.html(that.template());
            that.subPage = '.settingspanel-container';
            that.pages = {
                account: accountView,
                notification: notificationView,
                service: servicesView,
                hook: hooksView,
                project: projectView,
            };
            $('.settings-panel-nav a').eq(0).trigger('click');
        },
        navigation: function (e) {
            e.preventDefault();
            var that = this;
            var $this = $(e.currentTarget);
            $this.siblings().removeClass('active-cs');
            $this.addClass('active-cs');
            var page = $this.attr('data-page');

            try {
                if (this[page])
                    this[page].undelegateEvents();

                this[page] = new this.pages[page]({
                    el: that.subPage
                });
                this[page].render();
            } catch (e) {
                console.log('We dont know what this is: ' + page);
            }
        }
    });
    return d;
});