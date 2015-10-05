define([
    'text!pages/settings/projects.html'
], function (page) {
    d = Backbone.View.extend({
        events: {},
        render: function () {
            var that = this;
            this.$el.html(this.$e = $('<div class="bb-loading side-anim">').addClass(viewClass()));
            this.template = _.template(page);
            $.ajax({
                url: base + 'api/deploy/only',
                data: {
                    size: true,
                    select: 'id,name,git_name,repository'
                },
                method: 'get',
                dataType: 'json'
            }).done(function (res) {
                that.$e.html(that.template({
                    data: res.data
                }));
            });
            setTitle('Projects | Settings');
        }
    });
    return d;
});