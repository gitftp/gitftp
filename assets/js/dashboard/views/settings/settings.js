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
        events: {},
        render: function (path) {
            var that = this;
            setTitle('Settings');
            if (!$('.settingspageloaded').length) {
                this.$el.html(this.el = $('<div class="bb-loading">').addClass(viewClass()));
                this.template = _.template(page);
                that.el.html(that.template());
            }

            that.subPage = '.settingspanel-container';
            that.pages = {
                basic: accountView,
                notifications: notificationView,
                services: servicesView,
                webhooks: hooksView,
                projects: projectView,
            };

            if (!path) {
                Router.navigate('/settings/basic', {
                    trigger: true,
                    replace: true
                });
                return false;
            }
            this.loadSubPage(path);
        },
        loadSubPage: function (path) {
            // loading this path.
            var $list = $('.settings-panel-nav a');
            $list.siblings().removeClass('active-cs');
            $list.filter(function () {
                return $(this).attr('data-page') == path;
            }).addClass('active-cs');
            var page = path;

            try {
                if (this[page])
                    this[page].undelegateEvents();

                this[page] = new this.pages[page]({
                    el: this.subPage
                });
                this[page].render();
            } catch (e) {
                Router.navigate('/settings/basic', {
                    trigger: true,
                    replace: true
                });
            }
        }
    });
    return d;
});