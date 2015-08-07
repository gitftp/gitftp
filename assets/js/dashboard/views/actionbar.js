define([
    'text!pages/actionbar.html'
], function (fbView) {
    d = Backbone.View.extend({
        el: 'body',
        events: {
            'click .feedback': 'feedback',
        },
        render: function (id) {
            this.$el.append(fbView);
        },
        feedback: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);

            $.confirm({
                container: 'body',
                title: 'Feedback',
                icon: 'fa fa-smile-o green',
                content: 'Hey! let us know what you think about gitftp, and how it can be better. <br>' +
                '<div class="space10"></div>' +
                '<label>Your message</label>' +
                '<form>' +
                '<textarea style="resize: none; height: 100px;" name="message" class="form-control" placeholder="Anything you loved &hearts;, or anything you want to be improved. Let us know."/></textarea>' +
                '</form>',
                confirmButton: 'Send',
                cancelButton: 'close',
                confirm: function () {
                    var that = this;
                    var $form = this.$b.find('form');
                    $form.validate({
                        debug: true,
                        submitHandler: function () {
                            return false;
                        },
                        rules: {
                            message: {
                                required: true,
                                minlength: 50,
                                maxlength: 200
                            }
                        }
                    });
                    if ($form.valid()) {
                        var data = $form.serializeArray();
                        that.$b.find(':input').prop('disabled', true);
                        that.$confirmButton.html('<i class="fa fa-spin fa-spinner"></i> Sending');

                        _ajax({
                            url: base + 'api/etc/feedback',
                            data: data,
                            method: 'post',
                            dataType: 'json',
                        }).always(function () {
                            that.$b.find(':input').prop('disabled', false);
                            that.$confirmButton.html('send');
                        }).done(function (data) {
                            if (data.status) {
                                that.close();
                                $.alert({
                                    title: 'Submitted',
                                    content: 'Thank you for your support, we appreciate it.',
                                    confirmButton: 'close'
                                })
                            }
                        });
                    }
                    return false;
                },
                onOpen: function () {
                    this.$b.find('textarea').focus();
                }
            });
        },
    });
    return d;
});