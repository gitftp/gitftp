define([
    'text!pages/project/settings.html',
], function (settingsHtml) {
    /**
     * Project Settings.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .deleteproject': 'deleteProject',
            'change #doesreponeedlogin': 'inputCheckboxToggle',
            //'click #deploy-view-form-edit': 'updateSettings',
            'click .project-form-password-set-change': 'togglePasswordChange',
            'click .project-form-password-set-cancel': 'togglePasswordChange'
        },
        togglePasswordChange: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);

            var $set = $('.project-form-password-set'),
                $field = $('.project-form-password-field');

            if ($field.is(':visible')) {
                $field.find('input').prop('disabled', true);
                $field.hide();
                $set.show();
            } else {
                $field.show();
                $set.hide();
                $field.find('input').prop('disabled', false);
            }
        },
        deleteProject: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');

            $.confirm({
                title: 'Delete',
                content: 'Do you want to permanently delete this project and its related data?<br>' +
                'Following will not be affected: <br><br>' +
                '<ul class="bold">' +
                '<li>Your Git repository.</li>' +
                '<li>Files on FTP server.</li>' +
                '</ul>',
                theme: 'white',
                icon: 'fa fa-warning orange',
                confirmButton: 'proceed',
                confirmButtonClass: 'btn-warning',
                confirm: function () {

                    $.confirm({
                        title: 'Sure',
                        content: 'You cannot undo this action.',
                        icon: 'fa fa-info red',
                        confirmButton: 'Delete',
                        confirmButtonClass: 'btn-danger',
                        autoClose: 'cancel|10000',
                        theme: 'white',
                        confirm: function () {

                            _ajax({
                                url: base + 'api/deploy/delete/' + id,
                                dataType: 'json',
                                method: 'delete',
                            }).done(function (data) {

                                if (data.status) {
                                    $.alert({
                                        title: 'Deleted',
                                        content: 'The project was successfully deleted.'
                                    });
                                    Router.navigate('#/project', {
                                        trigger: true,
                                    })
                                } else {
                                    $.alert({
                                        title: 'Could not delete.',
                                        content: 'Sorry, <br><code>' + data.reason + '</code>',
                                    });
                                }
                            });
                        }
                    });
                }
            });
        },
        inputCheckboxToggle: function (e) {
            var $this = $(e.currentTarget);
            var $p = $('.privaterepo-toggle');
            if ($this.prop('checked')) {
                $p.show();
            } else {
                $p.hide();
            }
        },
        updateSettings: function () {
            var that = this;
            var $this = this.$form;
            var data = $this.serializeArray();
            $this.find('select, input, button').attr('disabled', true);

            _ajax({
                url: base + 'api/deploy/update/' + that.id,
                data: data,
                method: 'post',
                dataType: 'json',
            }).done(function (data) {
                if (data.status) {
                    noty({
                        text: 'Updated project: ' + data.request.name,
                        type: 'success'
                    });
                    app_reload();
                } else {
                    $.alert({
                        title: 'Something went wrong.',
                        content: data.reason
                    });
                }
            }).always(function () {
                $this.find('select, input, button').removeAttr('disabled');
            });
        },
        validation: function () {
            var that = this;

            this.$form.validate({
                debug: true,
                submitHandler: function () {
                    that.updateSettings();
                    return false;
                },
                errorClass: 'error',
                rules: {
                    'name': {
                        required: true,
                        maxlength: 50
                    },
                    username: {
                        required: {
                            depends: function () {
                                return $('#doesreponeedlogin').is(':checked');
                            }
                        }
                    },
                    'password': {
                        required: false
                    },
                    'key': {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: 'Please enter a name',
                        maxlength: 'Name cannot be longer than 50 chars'
                    }
                }
            })
        },
        initialize: function () {
            this.template = _.template(settingsHtml);
        },
        render: function (id) {
            var that = this;
            this.id = id;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));

            _ajax({
                url: base + 'api/deploy/get/' + id,
                method: 'get',
                dataType: 'json'
            }).done(function (response) {
                that.data = response;
                var subPage = that.template({
                    data: response.data[0]
                });
                that.$e.html(subPage);
                that.$form = that.$e.find('#deploy-view-form-edit');
                that.validation();
            });
        }
    });

    return d;
});