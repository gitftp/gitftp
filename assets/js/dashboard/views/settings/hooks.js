define([
    'text!pages/settings/hooks.html'
], function (page) {
    d = Backbone.View.extend({
        events: {
            'click .changekey': 'changekey'
        },
        changekey: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.data('id');
            var key = $this.data('key');

            $.confirm({
                title: 'Change hook key',
                content: 'A random string to help Gitftp authorize the valid source.' +
                '<br>' +
                '<form>' +
                '<input class="form-control key" name="key" type="text" value="' + key + '" placeholder="Your key">' +
                '</form>',
                onOpen: function () {
                    var jc = this;
                    this.$b.find('form').validate({
                        submitHandler: function (form) {
                            key = $(form).find('.key').val();
                            var lo = $.alert({
                                backgroundDismiss: false,
                                icon: 'gf gf-loading gf-block gf-alert',
                                title: 'Please wait',
                                content: 'Making changes, this will only take a few seconds',
                                confirmButton: false,
                                closeIcon: false,
                            });
                            _ajax({
                                url: base + 'api/etc/webhook',
                                method: 'post',
                                data: {
                                    id: id,
                                    key: key
                                },
                                dataType: 'json'
                            }).done(function (res) {
                                if (res.status) {
                                    noty({
                                        text: 'Successfully changed webhook key',
                                        type: 'success'
                                    });
                                    app_reload();
                                } else {
                                    noty({
                                        text: res.reason,
                                        type: 'error'
                                    });
                                }
                                lo.close();
                                jc.close();
                            });
                        },
                        rules: {
                            key: {
                                required: true,
                                minlength: 10,
                                maxlength: 10,
                            }
                        }
                    });
                },
                confirm: function () {
                    this.$b.find('form').submit();
                    return false;
                },
                confirmButton: 'change'
            });
        },
        render: function () {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading side-anim">').addClass(viewClass()));
            this.template = _.template(page);
            $.ajax({
                url: base + 'api/etc/webhook',
                method: 'get',
                dataType: 'json'
            }).done(function (res) {
                that.$e.html(that.template({
                    data: res.data
                }));
            });
            setTitle('Hooks | Settings');
        }
    });
    return d;
});