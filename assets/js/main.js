$(function () {

//    ajaxHelper
    window._ajax = function (arg) {
        return $.ajax(arg)
                .error(function (data) {
                    switch (data.status) {
                        case 0:
                    _.problem({text: ''})
                            break;
                    }
                })
    }
    window._problem = function (a) {
        $.confirm({
            title: 'Problem',
            content: a.text,
            icon: 'fa fa-rocket',
        })
    }
    window._debug = true;
});