define([
    'text!pages/settings/account.html'
], function (page) {
    d = Backbone.View.extend({
        render: function () {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));
            this.template = _.template(page);
            that.$e.html(that.template());
            this.validation();
        },
        validation: function () {
            var that = this;
            this.$form = $('#settings-update-password');
            this.$form.validate({
                debug: true,
                submitHandler: function (form) {
                    var data = $(form).serializeArray();
                    that.$form.find(':input').attr('disabled', 'disabled');
                    that.$form.find('button').html('<i class="fa fa-spin fa-spinner"></i> Updating..');
                    _ajax({
                        url: base + 'api/user/changepassword',
                        method: 'post',
                        data: data,
                        dataType: 'json',
                    }).done(function (data) {
                        if (data.status) {
                            $.alert({
                                title: 'Password changed',
                                icon: 'fa fa-info blue',
                                content: 'Your password has been changed successfully.',
                                confirmButton: 'close',
                            });
                        } else {
                            console.log(data.reason);
                            $.alert({
                                title: 'Problem',
                                icon: 'fa fa-warning orange',
                                content: data.reason,
                                confirmButton: 'close'
                            });
                        }
                    }).always(function () {
                        that.$form.find(':input').removeAttr('disabled');
                        that.$form.find('button').html('update');
                    });
                },
                errorClass: 'error',
                rules: {
                    oldpassword: {
                        required: true,
                    },
                    newpassword: {
                        required: true,
                        minlength: 6,
                        maxlength: 11,
                    },
                    newpassword2: {
                        required: true,
                        equalTo: '#newpassword',
                        minlength: 6,
                        maxlength: 11,
                    }
                }
            })
        }
    });
    return d;
})
;