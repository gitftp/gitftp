$(function () {

//    ajaxHelper
    var ajax = function (arg) {
        return $.ajax(arg)
                .error(function () {
                    alert('some error ');
                })
    }

});