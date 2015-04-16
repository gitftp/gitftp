$(function () {
    
    $(document).on('submit', '#home-login-module', function(e){
        e.preventDefault();
        var $this = $(this);

        _ajax({
        	url : base+ 'user/login',
        	data: $this.serializeArray(),
        	method: 'post',
        	dataType: 'json',
        }).done(function(data){
        	console.log(data);

        });

    });
    
});