define([
    'views/dashboard',
    'views/ftp',
    'views/ftpadd',
    'views/project',
    'views/projectadd',
    'views/projectview',
    'views/settings/settings',
], function (dashboard, ftpView, ftpAdd, projectView, projectaddView, projectviewView, settingsView) {

    var r = Backbone.Router.extend({
        routes: {
            '': 'dashboard',
            'home': 'dashboard',
            'ftp': 'ftpView',
            'ftp/add': 'ftpAdd',
            'ftp/edit/:id': 'ftpAdd',
            'project': 'project',
            'project/new': 'projectadd',
            'project/*path': 'projectview',
            'user/settings': 'settings',
            ':any': 'fourofour',
        },
        projectview: function (str) {
            app.obj.projectview = app.obj.projectview || new projectviewView();
            app.obj.projectview.render(str);
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
        ftpAdd: function (id) {
            app.obj.ftpAdd = app.obj.ftpAdd || new ftpAdd();
            app.obj.ftpAdd.render(id);
        },
        settings: function(){
            app.obj.settings = app.obj.settings || new settingsView();
            app.obj.settings.render();
        },
        fourofour: function () {
            Router.navigate('/home', {trigger: true, replace: true});
        }

    });

    return {
        router: r
    };

});
    