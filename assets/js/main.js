

$(function () {

    if ($('#ftpadd').length) {
        $('#ftpadd').on('submit', function (e) {
            e.preventDefault();

            $.post(base + 'api/addftp', $(this).serializeArray(), function (data) {
                console.log(data);
            });
        });
    }

});