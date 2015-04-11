$(function () {

//    ajaxHelper
    window.ajax = function (arg) {
        return $.ajax(arg)
                .error(function () {
                    alert('some error ');
                })
    }

});