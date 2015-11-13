define([], function () {
    var a = Backbone.Collection.extend({
        url: base + 'api/deploy/get',
    });

    return app.obj.projects_c || new a();
});