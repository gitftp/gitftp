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
            'submit #deploy-view-form-edit': 'updateSettings',
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
                        animation: 'scale',
                        confirmButtonClass: 'btn-danger',
                        autoClose: 'cancel|10000',
                        theme: 'white',
                        confirm: function () {

                            _ajax({
                                url: base + 'api/deploy/delete/' + id,
                                dataType: 'json',
                                method: 'get',
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
                $p.show().find('input').removeAttr('disabled').attr('required', true);
            } else {
                $p.hide().find('input').attr('disabled', true).removeAttr('required');
            }
        },
        updateSettings: function (e) {
            var that = this;
            var $this = $(e.currentTarget);
            e.preventDefault();

            $this.find('select, input, button').attr('readonly', true);

            _ajax({
                url: base + 'api/deploy/edit/' + that.parent.id,
                data: $this.serializeArray(),
                method: 'post',
                dataType: 'json',
            }).done(function (data) {
                if (data.status) {
                    $.alert({
                        title: 'Updated ' + data.request.name,
                        content: 'Respository is updated!',
                    });
                    app_reload();
                } else {
                    $.alert({
                        title: 'Something went wrong.',
                        content: data.reason
                    });
                }
            }).always(function () {
                $this.find('select, input, button').removeAttr('readonly');
            });
        },
        render: function (parent) {
            this.parent = parent;
            var that = this;
            $(this.parent.subPage).html('');
            that.template = _.template(settingsHtml);
            var subPage = that.template({
                data: that.parent.data.data[0],
            });
            $(this.parent.subPage).html(subPage);
        }
    });

    return d;
});