define([
    'text!pages/project.html'
], function (page) {
    /**
     * PROJECT LISTING.
     */
    d = Backbone.View.extend({
        el: app.el,
        events: {
            'click .viewdeploy': 'goto',
            'click .deletedeploy': 'delete'
        },
        delete: function (e) {
            e.stopPropagation();
            e.preventDefault();
            var $this = $(e.currentTarget);
            var id = $this.attr('data-id');

            $.confirm({
                
                title: 'Sure?',
                content: 'Are you sure to delete this deploy',
                confirm: function () {
                    
                    $this.find('i').removeClass('fa-trash-o').addClass('fa-ban').unwrap();
                    $this.parents('tr').removeClass('viewdeploy').fadeTo(400, .3);
                    
                    $.getJSON(base + 'api/deploy/delete/' + id, function (data) {
                        
                        if (data.status) {
                            noty({
                                text: '!! deleted',
                            });
                            
                            Backbone.history.loadUrl();
                        } else {
                            noty({
                                text: 'there was problem while deleting'
                            });
                        }
                    });
                }
            });
        },
        goto: function (e) {
            var $this = $(e.currentTarget);
            Router.navigate('deploy/v/' + $this.attr('data-id'), {trigger: true});
        },
        render: function (id) {
            var that = this;

            that.$el.html('');
            this.page = page;
            this.template = _.template(this.page);

            $.getJSON(base + 'api/deploy/getall', function (data) {
                var template = that.template({'list': data.data});
                that.$el.html(template);
            });
        }
    });

    return d;
});