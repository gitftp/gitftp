/**
 * Created by boniface on 7/12/2015.
 */
define([], function () {

    return {
        bindEvents: function () {
            var that = this;

            this.jconfirm.$b.find('.jc-global-update').on('click', function (e) {
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

            this.jconfirm = $.confirm({
                title: false,
                content: '' +
                '<div class="jconfirm-deploy-options">' +
                '<div class="deploytitle">Deploy type:</div>' +
                '<div class="row">' +
                '<div class="col-md-4 col-sm-4"><a href="#" class="jc-global-update"><i class="fa fa-level-up"></i><br>Update latest</a></div>' +
                '<div class="col-md-4 col-sm-4"><a href="#" class="jc-global-sync"><i class="fa fa-refresh"></i><br>Sync all files</a></div>' +
                '<div class="col-md-4 col-sm-4"><a href="#" class="jc-global-revert"><i class="fa fa-reply"></i><br>Jump to revision</a></div>' +
                '</div>' +
                '</div>',
                confirmButton: false,
                cancelButton: false,
                //columnClass: "col-md-4 col-md-offset-4",
                onOpen: function () {
                    that.bindEvents();
                }
            });
        },
        deploySync: function(e, a){
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
                    'type': 'sync',
                },
                method: 'post',
                dataType: 'json',
            }).done(function (data) {
                if (data.status) {
                    noty({
                        text: '<i class="fa fa-check fa-2x"></i>&nbsp; Deploy is Queued, will be processed shortly.',
                        type: 'success'
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
        deployRevert: function (e, a, hash) {
            // TODO : not done.

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
                '<input class="form-control" placeholder="Revision to deploy"/>',
                confirmButton: 'Deploy',
                confirm: function(){
                    var $input = this.$b.find('input');
                    var hash = $input.val();
                    var obj = this;

                    _ajax({
                        url: dash_url + 'api/deploy/run/',
                        data: {
                            'branch_id': branch_id,
                            'deploy_id': deploy_id,
                            'type': 'revert',
                            'hash': hash
                        },
                        method: 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        if (data.status) {
                            noty({
                                text: '<i class="fa fa-check fa-2x"></i>&nbsp; Deploy is Queued, will be processed shortly.',
                                type: 'success',
                            });
                            obj.close();
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
                    return false;
                },
                columnClass: 'col-md-4 col-md-offset-4',
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
                        text: '<i class="fa fa-check fa-2x"></i>&nbsp; Deploy is Queued, will be processed shortly.',
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