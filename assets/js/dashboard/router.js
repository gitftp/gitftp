define([
    'views/dashboard',
    'views/ftp',
    'views/ftpadd',
    'views/project',
    'views/projectadd',
], function (dashboard, ftpView, ftpAdd, projectView, projectaddView) {

    if (!/dashboard/ig.test(location.href)) {
        return false;
    }

    var r = Backbone.Router.extend({
        routes: {
            '': 'fourofour',
            'home': 'dashboard',
            'ftp': 'ftpView',
            'ftp/add': 'ftpAdd',
            'deploy': 'project',
            'deploy/new': 'projectadd',
            ':any': 'fourofour'
        },
        projectadd: function () {
            app.obj.projectadd = app.obj.projectadd || new projectaddView();
            app.obj.projectadd.render();
        },
        project: function () {
            app.obj.project = app.obj.project || new projectView();
            app.obj.project.render();
        },
        dashboard: function () {
            app.obj.dashboard = app.obj.dashboard || new dashboard();
            app.obj.dashboard.render();
        },
        ftpView: function () {
            app.obj.ftpView = app.obj.ftpView || new ftpView();
            app.obj.ftpView.render();
        },
        ftpAdd: function () {
            app.obj.ftpAdd = app.obj.ftpAdd || new ftpAdd();
            app.obj.ftpAdd.render();
        },
        fourofour: function(){
            Router.navigate('home', {trigger: true});
        }
    });

    return {
        router: r
    };

});
    