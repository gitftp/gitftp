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
            $('.linkService, .unlinkService').prop('disabled', true);
            window.location.href = home_url + 'api/user/authorize/' + name;
        },
        unlinkService: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            $this.find('i').removeClass('fa-times-circle').addClass('fa-spin fa-spinner');
            $('.linkService, .unlinkService').prop('disabled', true);
            var name = $this.data('name');
            var that = this;

            $.ajax({
                url: base + 'api/etc/unlinkprojects',
                method: 'get',
                data: {
                    provider: name
                },
                dataType: 'json'
            }).done(function (res) {
                console.log(res);

                if (res.projects.length) {
                    var list = '';
                    $.each(res.projects, function (i, a) {
                        list += '<li>' + a.name + '</li>';
                    });
                    $.confirm({
                        title: 'Are you sure',
                        icon: 'fa fa-question orange fa-fw',
                        content: 'Projects added via this service will be Deactivated & will be listed for deletion.' +
                        '<br><strong>Following will be Deactivated</strong>:<br><br>' +
                        '<ul>' + list + '</ul>',
                        confirm: function () {
                            that.removeService(name);
                        },
                        confirmButton: '<i class="fa fa-unlink"></i> Unlink',
                        cancel: function () {
                            $this.find('i').addClass('fa-times-circle').removeClass('fa-spin fa-spinner');
                            $('.linkService, .unlinkService').prop('disabled', false);
                        }
                    });
                } else {
                    that.removeService(name);
                    $this.find('i').addClass('fa-times-circle').removeClass('fa-spin fa-spinner');
                    $('.linkService, .unlinkService').prop('disabled', false);
                }
            }).always(function () {

            });
        },
        removeService: function (name) {
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