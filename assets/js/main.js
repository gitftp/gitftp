$(function () {

//    ajaxHelper
    window._ajax = function (arg) {
        return $.ajax(arg)
                .error(function (data) {
                    switch (data.status) {
                        case '0':
                            $.alert({
                                title: 'Problem', 
                                content: 'Servers have gone away, please check if you have a active internet connection.',
                                icon: 'fa fa-rocket'
                            })
                            break;
                    }
                })
    }
    
    window._debug = true;});