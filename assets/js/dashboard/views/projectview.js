define([
    'text!pages/project/main.html',
    'views/project/activity',
    'views/project/settings',
    'views/project/environments',
    'views/project/environments-manage',
    'views/project/environments-add',
], function (main, activityView, settingsView, environmentsView, manageenvironmentsView, addenvironmentsView) {

    d = Backbone.View.extend({
        el: app.el,
        events: {},
        page: {},
        render: function (url) {
            var that = this;
            this.url = url;
            this.urlp = url.split('/');
            this.id = this.urlp[0];

            // page find.
            if (this.urlp.length == 1) {
                var page = 'activity';
            } else if (this.urlp.length == 2) {
                var page = this.urlp[1];
            } else if (this.urlp.length > 2) {
                var page = this.urlp[2];
            }

            this.subPage = '.deploy-sub-page';

            // save 'which' page.
            this.which = page;
            console.log('page is ', page);

            var is_loaded = ($('.project-v-status').length) ? true : false;
            if (!is_loaded) {
                this.$el.html(this.el = $('<div class="bb-loading">').addClass(viewClass()));
            }

            // save templates.
            this.page = {
                main: main,
            };
            // save the compiled templates
            this.template = {
                main: _.template(this.page.main),
            };

            if (is_loaded) {
                that.makeMenuSelection();
                that.renderChild();
                return false;
            }

            this.getData().done(function (data) {
                that.data = data;

                if (data.data.length == 0) {
                    Router.navigate('#/project', {
                        trigger: true,
                        replace: true,
                    });
                    return false;
                }
                if (is_loaded) {

                } else {
                    var template = that.template.main({
                        's': data.data[0]
                    });
                    that.el.html(template);
                    that.makeMenuSelection();
                    that.renderChild();
                }
            });
        },
        getData: function () {
            return _ajax({
                url: base + 'api/deploy/get/' + this.id,
                method: 'get',
                dataType: 'json'
            });
        },
        makeMenuSelection: function () {
            console.log(this.which);
            var $menuItems = $('.projectview-siderbar');
            $menuItems.find('a.list-group-item').removeClass('active-cs');

            switch (this.which) {
                case 'activity':
                    $menuItems.find('.subview-activity').addClass('active-cs');
                    break;
                case 'add':
                case 'manage':
                case 'environments':
                    $menuItems.find('.subview-environments').addClass('active-cs');
                    break;
                case 'settings':
                    $menuItems.find('.subview-settings').addClass('active-cs');
                    break;
            }
        },
        renderChild: function () {
            var that = this;
            if (typeof this['_' + this.which] == 'function') {
                this['_' + this.which]();
            } else {
                console.log('404: page not found');
            }
        },
        _add: function () {
            this.add_environments = this.add_environments || new addenvironmentsView();
            this.add_environments.render(this);
        },
        _activity: function () {
            this.activity = this.activity || new activityView();
            this.activity.render(this);
        },
        _settings: function () {
            this.settings = this.settings || new settingsView();
            this.settings.render(this);
        },
        _environments: function () {
            this.environments = this.environments || new environmentsView();
            this.environments.render(this);
        },
        _manage: function () {
            this.manage_environments = this.manage_environments || new manageenvironmentsView();
            this.manage_environments.render(this);
        },
    })
    ;
    return d;
})
;