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
        forceDelete: function (id) {
            $.confirm({
                title: 'delete?',
                content: 'The project is currently being deployed, do you really want to delete the project?',
                theme: 'white',
                icon: 'fa fa-warning orange',
                confirmButton: 'Force Delete',
                confirmButtonClass: 'btn-warning',
                //autoClose: 'cancel|10000',
                confirm: function () {
                    var t2 = this;
                    t2.$confirmButton.html('<i class="gf gf-loading gf-btn"></i> Force Delete');
                    var $loading = $.dialog({
                        title: 'Please wait.',
                        content: 'Removing the project may take some time.',
                        icon: 'fa fa-spin fa-spinner',
                        theme: 'white',
                        closeIcon: false,
                        backgroundDismiss: false
                    });

                    _ajax({
                        url: base + 'api/deploy/delete/' + id,
                        dataType: 'json',
                        method: 'delete',
                        data: {
                            force: 1,
                        }
                    }).done(function (data) {
                        if (data.status) {
                            t2.close();
                            $.alert({
                                title: 'Deleted',
                                content: 'The project was successfully deleted.'
                            });
                            Router.navigate('/project', {
                                trigger: true
                            });
                        } else {
                            $.alert({
                                title: 'Could not delete.',
                                content: 'Sorry, <code>' + data.reason + '</code>'
                            });
                        }
                    }).always(function (data) {
                        t2.$confirmButton.find('i').remove();
                        $loading.close();
                    });
                }
            });
        },
        deleteProject: function (e) {
            var that = this;
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
                confirmButton: 'Delete',
                confirmButtonClass: 'btn-warning',
                autoClose: 'cancel|10000',
                confirm: function () {
                    var t2 = this;
                    t2.$confirmButton.html('<i class="gf gf-loading gf-btn"></i> Delete');
                    var $loading = $.dialog({
                        title: 'Please wait.',
                        content: 'Removing the project may take a little time.',
                        icon: 'gf gf-loading gf-block gf-alert',
                        theme: 'white',
                        closeIcon: false,
                        backgroundDismiss: false
                    });

                    _ajax({
                        url: base + 'api/deploy/delete/' + id,
                        dataType: 'json',
                        method: 'get',
                    }).done(function (data) {
                        if (data.status) {
                            t2.close();
                            $.alert({
                                title: 'Deleted',
                                content: 'The project was successfully deleted.'
                            });
                            Router.navigate('/project', {
                                trigger: true
                            });
                        } else {
                            if (typeof data.active !== 'undefined') {
                                that.forceDelete(id);
                            } else {
                                $.alert({
                                    title: 'Could not delete.',
                                    content: 'Sorry, <code>' + data.reason + '</code>'
                                });
                            }
                        }

                    }).always(function (data) {
                        t2.$confirmButton.find('i').remove();
                        $loading.close();
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
                dataType: 'json'
            }).done(function (data) {
                if (data.status) {
                    noty({
                        text: 'Updated project: ' + data.request.name,
                        type: 'success'
                    });
                    window.location.reload();
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
                    'key': 'validateKey'
                },
                messages: {
                    name: {
                        required: 'Please enter a name',
                        maxlength: 'Name cannot be longer than 50 chars'
                    }
                }
            });
            $.validator.addMethod('validateKey', function (v) {
                return (v.indexOf(' ') == -1) && (v.trim().length != 0)
            }, 'Please enter a valid key.');
        },
        initialize: function () {
            this.template = _.template(settingsHtml);
        },
        render: function (id) {
            var that = this;
            this.id = id;
            this.$el.html(this.$e = $('<div class="bb-loading project-activity-anim">').addClass(viewClass()));

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
                that.renderSize();
                that.totalDeploy();
            });
            setTitle('Settings | Projects');
        },
        totalDeploy: function () {
            $.ajax({
                url: base + 'api/etc/totaldeploy',
                data: {
                    id: this.id
                },
                method: 'get',
                dataType: 'json'
            }).done(function (res) {
                if (res.status) {
                    $('.project-deployed-count').html(res.size_human);
                }
            });
        },
        renderSize: function () {
            $.ajax({
                url: base + 'api/etc/sizeondisk',
                data: {
                    id: this.id
                },
                method: 'get',
                dataType: 'json'
            }).done(function (res) {
                if (res.status) {
                    $('.project-size').html(res.size_human);
                } else {
                    $('.project-size').html(res.reason);
                }
            });
        }
    });

    return d;
});