define([
    'text!pages/project/main.html',
    'views/project/activity',
    'views/project/settings',
    'views/project/environments',
    'views/project/environments-manage',
    'views/project/environments-add',
], function (main, activityView, settingsView, environmentsView, manageenvironmentsView, addenvironmentsView) {

    return Backbone.View.extend({
        el: app.el,
        events: {},
        initialize: function () {
            this.pages = {
                main: main,
                activity: activityView,
                settings: settingsView,
                environments: environmentsView,
                manage: manageenvironmentsView,
                add: addenvironmentsView
            }
            this.subPage = '.deploy-sub-page';
        },
        render: function (url) {
            var that = this;
            this.url = url;
            this.urlp = url.split('/');
            this.id = this.urlp[0];

            // page find.
            if (this.urlp.length == 1) {
                var page = 'activity';
                Router.navigate('/project/' + this.id + '/activity', {
                    trigger: true,
                    replace: true
                });
                return false;
            } else if (this.urlp.length == 2) {
                var page = this.urlp[1];
            } else if (this.urlp.length > 2) {
                var page = this.urlp[2];
            }

            // save 'which' page.
            this.which = page;

            var is_loaded = ($('.project-v-status').length) ? true : false;
            if (!is_loaded) {
                this.$el.html(this.el = $('<div class="bb-loading">').addClass(viewClass()));
            } else {
                that.makeMenuSelection();
                that.renderChild();
                return false;
            }

            this.getData().done(function (response) {
                that.data = response;

                if (response.data.length == 0) {
                    Router.navigate('/project', {
                        trigger: true,
                        replace: true
                    });
                    return false;
                }

                // save the compiled templates
                var template = _.template(that.pages.main);
                var template = template({
                    's': response.data[0]
                });
                that.el.html(template);
                that.makeMenuSelection();
                that.renderChild();
            });
            setTitle('Projects');
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

            if (typeof this.pages[this.which] == 'undefined')
                console.log('PROJECT VIEW: not known page: ', this.which);

            if (this[this.which])
                this[this.which].undelegateEvents();

            this[this.which] = new this.pages[this.which]({
                el: this.subPage
            });
            this[this.which].render(this.id, this.urlp);

            console.log('PROJECT VIEW: page', this.which);
        }
    });
});