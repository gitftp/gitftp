define([
    'text!pages/projectadd.html'
], function (page) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit #deploy-save-new': 'savenew',
            'keyup input#add-repo': 'calcname'
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
            that.$el.html('');
            this.page = page;
            this.template = _.template(this.page);

            $.getJSON(base + 'api/ftp/getall', function (data) {
                var page = that.template({'ftplist': data.data});
                that.$el.html(page);
            });
        }
    });

    return d;
});