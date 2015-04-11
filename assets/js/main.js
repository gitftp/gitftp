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
                    }
                })
    }
    window._problem = function (a) {
        

        $.confirm({
            title: 'Problem',
            content: a.text,
            icon: 'fa fa-rocket',
            confirmButtonClass: 'btn-warning'
        })
    }
    window._debug = true;
});