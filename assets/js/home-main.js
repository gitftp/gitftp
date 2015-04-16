$(function () {
    
    $(document).on('submit', '#home-login-module', function(e){
        e.preventDefault();
        var $this = $(this);

        $this.find('button[type="submit"]').html('<i class="fa fa-spin fa-spinner"></i> Login').attr('disabled', true);
        $this.find('input, select').attr('readonly', true);

        _ajax({

        	url : base + 'user/login',
        	data: $this.serializeArray(),
        	method: 'post',
        	dataType: 'json',

        }).done(function(data){
        	if(data.status){

	        	$this.find('button[type="submit"]').html('Login').removeAttr('disabled');
	        	$this.find('input, select').removeAttr('readonly');
	        	$.alert({
	        		title: 'Logged in.',
	        		content: 'You are logged in, redirecting you.'
	        	});
	        	location.href = data.redirect;

        	}else{

	        	$this.find('button[type="submit"]').html('Login').removeAttr('disabled');
	        	$this.find('input, select').removeAttr('readonly');
	        	$.alert({
	        		title: 'Problem here.',
	        		content: data.reason
	        	});

        	}
        });

    });
    
});