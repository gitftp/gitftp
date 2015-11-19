<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Settings
                </div>
                <table class="table table-bordered table-hover table-condensed">
                    <tr>
                        <th width="30%">
                            name
                        </th>
                        <th>
                            value
                        </th>
                        <th></th>
                    </tr>
                    <tr>
                        <form class="form-add" method="POST">
                            <td>
                                <input type="text" name="name" class="form-control"/>
                            </td>
                            <td>
                                <input type="text" name="value" class="form-control"/>
                            </td>
                            <td>
                                <button class="btn btn-primary" type="submit">Create</button>
                            </td>
                        </form>
                    </tr>
                    <?php foreach($options as $option){ ?>
                        <tr>
                            <td style="vertical-align: middle;font-weight:bold" class="text-right">
                                <?php echo $option['name'] ?>
                            </td>
                            <td>
                                <input data-name="<?php echo $option['name'] ?>" type="text" class="form-control changename" value="<?php echo $option['value'] ?>"/>
                            </td>
                            <td class="text-center" style="vertical-align: middle">
                                <a href="#" data-name="<?php echo $option['name'] ?>" class="remove">Remove</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.form-add').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url: 'changevalue',
                data: $(this).serializeArray(),
                method: 'post',
            }).done(function(){
                location.reload();
            });
        });
        $('.changename').on('keyup', function(){
            var $this = $(this);
            var val = $this.val();
            var name = $this.attr('data-name');
            $.ajax({
                url: 'changevalue',
                data: {
                    name: name,
                    value: val,
                },
                method: 'post',
            });
        });
        $('.remove').click(function(){
            var $this = $(this);
            if(confirm('are you sure?')){
                $.ajax({
                    url: 'delete/'+$this.attr('data-name'),
                    method: 'get'
                }).done(function(){
                    $this.html('deleted');
                })
            }
        });
    });
</script>