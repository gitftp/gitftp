define([
    'views/dashboard',
    'views/ftp',
    'views/ftpadd',
], function (dashboard, ftpView, ftpAdd) {
    
    if(!/dashboard/.test(location.href)){
        return false;
    }
    
    var r = Backbone.Router.extend({
        routes: {
            '': 'dashboard',
            'ftp': 'ftpView',
            'ftp/add': 'ftpAdd',
        },
        dashboard: function () {
            app.obj.dashboard =  app.obj.dashboard || new dashboard();
            app.obj.dashboard.render();
        },
        ftpView: function(){
            app.obj.ftpView = app.obj.ftpView || new ftpView();
            app.obj.ftpView.render();
        },
        ftpAdd: function(){
            app.obj.ftpAdd = app.obj.ftpAdd || new ftpAdd();
            app.obj.ftpAdd.render();
        }
    });

    return {
        router: r
    };
    
});
    