define([
    'text!pages/ftpadd.html'
], function (ftpadd) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit #addftp-form': 'addftp'
        },
        render: function (id) {
            var that = this;
            that.$el.html('');
            that.$el.html(ftpadd);
        },
        addftp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            $this.find('select, input').attr('readonly', true);
            
            $.post(base + 'api/ftp/addftp', $this.serializeArray(), function (data) {
                $this.find('select, input').removeAttr('readonly');
                data = JSON.parse(data);
                if(data.status){
                    noty({
                        text: '!!! Added FTP server: '+$this.find('[name="host"]').val()
                    });
                    Router.navigate('ftp', {trigger: true});
                }
            });
        }
    });

    return d;
});