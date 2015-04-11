$(function () {

//    ajaxHelper
    window._ajax = function (arg) {
        return $.ajax(arg)
                .error(function (data) {
                    console.log('some error ',data);
                })
    }

});