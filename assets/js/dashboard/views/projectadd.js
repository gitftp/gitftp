define([
    'text!pages/projectadd.html'
], function (page) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit #deploy-save-new': 'savenew',
            'keyup input#add-repo': 'calcname',
            'change #deploy-add-privaterepo': 'priCheck',
            'click .testconnectiontorepo': 'getBranches',
        },
        getBranches: function(){
            if(this.branches){
                return false;
            }
            
            
            
            _ajax({
                url: base+ 'api/deploy/getbranches',
                data: {
                    repo: $('input[name="rpeo"]').val(),
                    username: ,
                    password: ,
                }
            })
            
            
        },
        priCheck: function (e) {
            var $this = $(e.currentTarget);
            if ($this.prop('checked')) {
                $('#deploy-add-privaterepo-div').show().find('input').removeAttr('disabled').attr('required', true);
            } else {
                $('#deploy-add-privaterepo-div').hide().find('input').attr('disabled', true).removeAttr('required');
            }
        },
        calcname: function (e) {
            var $this = $(e.currentTarget);
            var str = $this.val();
            var tar = $('#deploy-save-new input[name="name"]');
            var i = str.indexOf('.git');
            if (i !== -1) {
//                console.log(i, str.length);
                if (i == str.length - 4) {
                    var s = str.lastIndexOf('/');
                    var o = str.substring(s + 1, str.length - 4);
                    tar.val(o.toLowerCase());
                } else {
                    tar.val('');
                }
            } else {
                tar.val('');
            }

        },
        savenew: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            $this.find('select, input').attr('readonly', true);

            $.post(base + 'api/deploy/new', $this.serializeArray(), function (data) {
                $this.find('select, input').removeAttr('readonly');
                data = JSON.parse(data);

                if (data.status) {

                    $.alert({
                        title: 'Added',
                        content: 'The configuration is added, please proceed for first deployment.'
                    });
                    Router.navigate('deploy', {
                        trigger: true
                    });

                } else {
                    noty({
                        text: data.reason,
                        type: 'error'
                    });
                }
            });
        },
        render: function (id) {
            var that = this;

            this.$el.html(this.el = $('<div class="projectadd-wrapper bb-loading">'));
            this.page = page;
            this.template = _.template(this.page);
            
            _ajax({
                url: base + 'api/ftp/getall',
                dataType: 'json',
            }).done(function(data){
                if(data.data.length == 0){
                    $.confirm({
                        title: 'No FTP servers found.',
                        content: 'To setup a deploy, you first need to add a FTP server configuration.',
                        confirmButton: 'Add ftp',
                        confirm: function(){
                            Router.navigate('#ftp/add', {
                                trigger: true
                            });
                        },
                        confirmButtonClass: 'btn-success'
                    })
                }
                var page = that.template({'ftplist': data.data});
                that.el.html(page);
            });
        }
    });

    return d;
});