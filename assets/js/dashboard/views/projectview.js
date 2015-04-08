define([
    'text!pages/projectview.html',
    'text!pages/projectActivity.html',
    'text!pages/projectSettings.html',
], function (main, activityView, settingsView) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .startdeploy': 'startDeploy',
            'change #deploy-add-privaterepo': 'priCheck'
        },
        priCheck: function (e) {
            var $this = $(e.currentTarget);
            if ($this.prop('checked')) {
                $('#deploy-add-privaterepo-div').show().find('input').removeAttr('disabled').attr('required', true);
            } else {
                $('#deploy-add-privaterepo-div').hide().find('input').attr('disabled', true).removeAttr('required');
            }
        },
        render: function (id, which) {

            var that = this;
            if (which == null) {
                this.which = 'activity';
            } else {
                this.which = which;
            }

            this.page = {
                main: main,
                activity: activityView,
                settings: settingsView,
            };

            that.$el.html('');

            this.template = {
                main: _.template(this.page.main),
                activity: _.template(this.page.activity),
                settings: _.template(this.page.settings)
            };
            this.id = id;

            $.getJSON(base + 'api/deploy/getall/' + id, function (data) {
                var template = that.template.main({'s': data.data[0], 'v': that.which});
                that.data = data;
                that.$el.html(template);
                that.renderChild();
            });
        },
        renderChild: function () {
            var that = this;
            if (this.which == 'activity') {
                $.getJSON(base + 'api/records/getall/' + this.id, function (data) {
                    var subPage = that.template[that.which]({
                        's': that.data.data[0],
                        'activity': data
                    });
                    $('.deploy-sub-page').html(subPage);
                });
            }
            if (this.which == 'settings') {
                var subPage = this.template[this.which]({'s': this.data.data[0]});
                $('.deploy-sub-page').html(subPage);
            }

        },
        startDeploy: function () {
            $.getJSON(base + 'api/deploy/start/' + this.id, function (data) {
                if (data.status) {
                    $.alert({
                        title: 'Woohoo!',
                        content: 'Your repository is deployed for the first time !, Cheers'
                    });

                    Backbone.history.loadUrl();

                } else {
                    $.alert({
                        title: 'Problem',
                        content: 'There was a problem. RUN FOR YOUR LIFE!!!!'
                    });
                }
            });
        }
    });

    return d;
});