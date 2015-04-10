define([
    'text!pages/ftpadd.html'
], function (ftpadd) {

    d = Backbone.View.extend({
        el: app.el,
        events: {
            'submit #addftp-form': 'addftp',
            'keyup #addftp-form input': 'oneline',
            'click .ftp-connectionTest': 'testFtp',
        },
        testFtp: function(){
            var form = $('#addftp-form').serializeArray();
            $.post(base+'api/ftp/testftp', form, function(d){
                
            });
        },
        oneline: function () {
            var $target = $('.ftp-oneline');
            var str = '';
            var host = $('input[name="host"]').val();
            var username = $('input[name="username"]').val();
            var pass = $('input[name="pass"]').val();
            var scheme = $('input[name="scheme"]').val();
            var path = $('input[name="path"]').val();
            var port = $('input[name="port"]').val();

            if (/^(?!:\/\/)([a-zA-Z0-9]+\.)?[a-zA-Z0-9][a-zA-Z0-9-]+\.[a-zA-Z]{2,6}?$/i.test(host) || /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(host)) {
                if (scheme && /ftp|ftps|sftp/.test(scheme)) {
                    str += scheme + '://';
                } else {
                    str += 'ftp://';
                }
                if (username) {
                    str += username;
                    if (pass) {
                        str += ':' + pass;
                    }
                    str += '@';
                }
                if (host) {
                    str += host;
                }
                if (port) {
                    str += ':' + port;
                } else {
                    str += ':21';
                }
                if (path) {
                    str += '' + path;
                } else {
                    str += '/';
                }
            }

            if (str === '') {
                str = 'ftp://example:password@production-example.com:21/path/to/installation';
            }

            $target.html(str);
        },
        render: function (id) {
            var that = this;
            
            
            that.$el.html('');
            if(id){
                $.getJSON(base+'api/ftp/getall/'+id, function(data){
                    var template = _.template(ftpadd);
                    template = template({
                        'ftp': data.data
                    });
                    that.$el.html(template);
                });
                that.id = id;
            }else{
                var template = _.template(ftpadd);
                template = template({
                    'ftp': []
                });
                that.$el.html(template);
                that.id = false;
            }
        },
        addftp: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            $this.find('select, input').attr('readonly', true);
            var that = this;
            
            if(this.id){
                var to = 'editftp/'+this.id;
            }else{
                var to = 'addftp';
            }
            
            $.post(base + 'api/ftp/'+to, $this.serializeArray(), function (data) {
                $this.find('select, input').removeAttr('readonly');
                data = JSON.parse(data);
                if (data.status) {
                    noty({
                        text: '!!! '+ ((this.id) ? 'Edited' : 'Added') +' FTP server: ' + $this.find('[name="host"]').val()
                    });
                    Router.navigate('ftp', {trigger: true});
                } else {
                    $.alert({
                        title: 'Something bad happened',
                        content: data.reason
                    });
                }
            });
        }
    });

    return d;
});