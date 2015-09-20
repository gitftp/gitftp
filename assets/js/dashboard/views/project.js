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
            'click #new-project': 'new'
        },
        new: function(e){
            //var $this = $(e.currentTarget);
            //var plus = $this.html();
            //$this.html('<i class="fa fa-spin fa-spinner"></i>');
        },
        goto: function (e) {
            var $this = $(e.currentTarget);
            Router.navigate('/project/' + $this.attr('data-id'), {trigger: true});
        },
        render: function (id) {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading">').addClass(viewClass()));
            this.page = page;
            this.template = _.template(this.page);
            _ajax({
                url: base + 'api/deploy/only',
                dataType: 'json',
                method: 'get',
                data: {
                    select: 'id,created_at,name,repository,git_name'
                }
            }).done(function (data) {
                var template = that.template({'list': data.data});
                that.$e.html(template);
            });
            setTitle('Projects');
        }
    });

    return d;
});