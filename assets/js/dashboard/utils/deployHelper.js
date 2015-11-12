/**
 * Created by boniface on 7/12/2015.
 */
define([], function () {

    return {
        bindEvents: function () {
            var that = this;

            this.jconfirm.$b.find('.jc-global-update').on('click', function (e) {
                var $this = $(this);
                if($this.hasClass('focus'))
                    return false;
                $this.addClass('focus').find('i').removeAttr('class').addClass('fa fa-spin fa-spinner');
                that.deployUpdate(e);
            });
            this.jconfirm.$b.find('.jc-global-revert').on('click', function (e) {
                that.deployRevert(e);
            });
            this.jconfirm.$b.find('.jc-global-sync').on('click', function (e) {
                that.deploySync(e);
            });
        },
        showOptions: function (deploy_id, branch_id) {
            var that = this;

            this.deploy_id = deploy_id || undefined;
            this.branch_id = branch_id || undefined;

            var content = '' +
                '<div class="jconfirm-deploy-options">' +
                '<div class="deploytitle">Deploy type:</div>' +
                '<div class="row">' +
                '<div class="col-md-4 col-sm-4"><a href="#" class="jc-global-update"><i class="fa fa-level-up"></i><br>Update</a></div>' +
                '<div class="col-md-4 col-sm-4"><a href="#" class="jc-global-revert"><i class="fa fa-reply"></i><br>Revision</a></div>' +
                '<div class="col-md-4 col-sm-4"><a href="#" class="jc-global-sync"><i class="fa fa-refresh"></i><br>Upload all</a></div>' +
                '</div>' +
                '</div>';

            this.jconfirm = $.confirm({
                title: false,
                content: function () {
                    return _ajax({
                        url: base + 'api/branch/get/' + that.branch_id,
                        data: {
                            branch_id: that.branch_id
                        },
                        method: 'get',
                        dataType: 'json'
                    }).done(function (data) {
                        that.branch = data.data[0];
                        that.jconfirm.contentDiv.html(content);
                        that.bindEvents();
                    })
                },
                confirmButton: false,
                cancelButton: false,
                columnClass: 'col-md-6 col-md-offset-3',
                animation: 'opacity',
            });
        },
        deploySync: function (e, a) {
            var that = this;

            if (!a) {
                e.preventDefault();
                var deploy_id = this.deploy_id;
                var branch_id = this.branch_id;
            } else {
                var deploy_id = e;
                var branch_id = a;
            }

            $.confirm({
                title: (this.branch.ready == '1') ? 'Re-upload all files?' : 'Upload all files?',
                icon: 'fa fa-info orange',
                content: 'All files from repository will be uploaded. <br>' +
                '<span class="gray">This might take some time depending on the size of your repository</span>',
                confirmButton: 'Deploy',
                confirm: function () {
                    var jc = this;
                    jc.$confirmButton.html('<i class="gf gf-loading gf-btn"></i> ' + jc.confirmButton).prop('disabled', true);

                    _ajax({
                        url: dash_url + 'api/deploy/run/',
                        data: {
                            'branch_id': branch_id,
                            'deploy_id': deploy_id,
                            'type': 'sync'
                        },
                        method: 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        if (data.status) {
                            jc.close();
                            if (that.jconfirm) {
                                that.jconfirm.close();
                            }
                            noty({
                                text: 'Deploy is Queued, will be processed shortly.',
                                type: 'success'
                            });
                        } else {
                            noty({
                                text: data.reason,
                                type: 'error'
                            });
                        }
                    }).always(function () {
                        jc.$confirmButton.html('<i class="fa fa-spinner fa-spin"></i> ' + jc.confirmButton).prop('disabled', true);
                    });
                    return false;
                }
            })
        },
        deployRevert: function (e, a, hash) {
            var that = this;

            if (!a) {
                e.preventDefault();
                var deploy_id = this.deploy_id;
                var branch_id = this.branch_id;
            } else {
                var deploy_id = e;
                var branch_id = a;
            }

            $.confirm({
                title: 'Checkout revision',
                content: 'Deploy changes of a specific hash on the server.<br>' +
                '<form><input type="text" spellcheck="false" class="form-control mono" autocomplete="off" autocorrect="off" placeholder="Revision to deploy"/></form>' +
                '<div class="space5"></div><span class="orange"><strong>NOTE:</strong> You have auto deploy enabled.</span>',
                confirmButton: 'Deploy',
                confirm: function () {
                    var jc = this;
                    var $input = jc.$b.find('input').prop('readonly', true);
                    jc.$confirmButton.html('<i class="gf gf-loading gf-btn"></i> ' + jc.confirmButton).prop('disabled', true);
                    var hash = $input.val();

                    _ajax({
                        url: dash_url + 'api/deploy/run/',
                        data: {
                            'branch_id': branch_id,
                            'deploy_id': deploy_id,
                            'type': 'revert',
                            'hash': hash
                        },
                        method: 'post',
                        dataType: 'json'
                    }).done(function (data) {
                        if (data.status) {
                            noty({
                                text: 'Deploy is Queued, will be processed shortly.',
                                type: 'success'
                            });
                            jc.close();
                            if (that.jconfirm) {
                                that.jconfirm.close();
                            }
                            console.log(that.jconfirm);
                        } else {
                            noty({
                                text: data.reason,
                                type: 'error'
                            });
                        }
                    }).always(function(){
                        $input.prop('readonly', false);
                        jc.$confirmButton.html(jc.confirmButton).prop('disabled', false);
                    });
                    return false;
                },
                columnClass: 'col-md-4 col-md-offset-4',
                onOpen: function () {
                    var that = this;
                    this.$b.find('input').focus();
                    this.$b.find('form').submit(function(e){
                        e.preventDefault();
                        that.confirm();
                    })
                }
            });

        },
        deployUpdate: function (e, a) {
            var that = this;

            if (!a) {
                e.preventDefault();
                var deploy_id = this.deploy_id;
                var branch_id = this.branch_id;
            } else {
                var deploy_id = e;
                var branch_id = a;
            }

            _ajax({
                url: dash_url + 'api/deploy/run/',
                data: {
                    'branch_id': branch_id,
                    'deploy_id': deploy_id,
                    'type': 'update',
                },
                method: 'post',
                dataType: 'json',
            }).done(function (data) {
                if (data.status) {
                    noty({
                        text: 'Deploy is Queued, will be processed shortly.',
                        type: 'success',
                    });
                } else {
                    noty({
                        text: data.reason,
                        type: 'error'
                    });
                }
            }).always(function () {
                console.log(that);
                if (that.jconfirm) {
                    that.jconfirm.close();
                }
            });
        },
    }
});