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

            // save 'which' page.
            this.which = page;
            console.log('page is ', page);

            var is_loaded = ($('.project-v-status').length) ? true : false;
            if (!is_loaded) {
                this.$el.html(this.el = $('<div class="projectview-wrapper bb-loading">'));
            }

            // save templates.
            this.page = {
                main: main,
            };
            // save the compiled templates
            this.template = {
                main: _.template(this.page.main),
            };

            _ajax({
                url: base + 'api/deploy/getall/' + this.id,
                method: 'get',
                dataType: 'json'
            }).done(function (data) {
                if (data.data.length == 0) {
                    Router.navigate('#/project', {
                        trigger: true,
                        replace: true,
                    });
                    return false;
                }
                var template = that.template.main({
                    's': data.data[0],
                    'v': that.which
                });
                that.data = data;

                if (is_loaded) {
                    that.el.html(template);
                } else {
                    var $el2 = $('<div class="projectview-anim">');
                    that.el.html($el2);
                    that.el = $el2;
                    $el2.html(template);
                }

                that.renderChild();
            });

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

            this.add_environments = new addenvironmentsView({
                el: '.deploy-sub-page',
                id: this.id
            });
            this.add_environments.data = this.data;
            this.add_environments.render();

        },
        _activity: function () {
            this.activity = new activityView({
                el: '.deploy-sub-page',
                id: this.id
            });
            this.activity.data = this.data;
            this.activity.render();
        },
        _settings: function () {
            this.settings = new settingsView({
                el: '.deploy-sub-page',
                id: this.id
            });
            this.settings.data = this.data;
            this.settings.render();
        },
        _environments: function () {
            this.environments = new environmentsView({
                el: '.deploy-sub-page',
                id: this.id
            });
            this.environments.data = this.data;
            this.environments.render();
        },
        _manage: function () {
            this.manage_environments = new manageenvironmentsView({
                el: '.deploy-sub-page',
                id: this.id
            });
            this.manage_environments.data = this.data;
            this.manage_environments.urlp = this.urlp;
            this.manage_environments.render();

        },
    })
    ;
    return d;
})
;