$(function () {

//    ajaxHelper
    window._ajax = function (arg) {
        return $.ajax(arg)
                .error(function (data) {
                    switch (data.status) {
                        case 0:
                            _problem({
                                content: 'Servers have gone away, please check if you have a active internet connection.',
                                confirm: function () {
                                    location.reload();
                                    return false;
                                },
                                confirmButton: '<i class="fa fa-refresh fa-fw"></i> Reload',
                            });
                            break;
                        default: 
                            alert('error :'+data.status);
                    }
                }).always(function(data){
                    if(!data.status){
                        
                        if(data.reason == 'GT-405'){
                            _problem({
                                content: 'You\'re not logged in, please login to proceed.'
                            })
                        }
                        
                    }
                })
    }
    window._problem = function (a) {
        var b = {};
        $.extend(b, a, {
            title: 'Problem',
            content: a.text,
            icon: 'fa fa-warning',
            confirmButtonClass: 'btn-warning'
        });
        $.confirm(b);
    }
    window._debug = true;
});