<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo Uri::create('administrator/settings/'); ?>">Variable
                    settings</a>
                <a class="btn btn-default disabled" href="<?php echo Uri::create('administrator/settings/path'); ?>">Path
                    settings</a>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Path
                </div>
                <table class="table table-bordered table-hover table-condensed">
                    <tr>
                        <th width="30%">
                            id
                        </th>
                        <th>
                            path
                        </th>
                        <th></th>
                    </tr>
                    <tr>
                        <form class="form-add" method="POST">
                            <td>
                            </td>
                            <td>
                                <input type="text" name="path" class="form-control"/>
                            </td>
                            <td>
                                <button class="btn btn-primary" type="submit">Create</button>
                            </td>
                        </form>
                    </tr>
                    <?php foreach ($options as $option) { ?>
                        <tr>
                            <td style="vertical-align: middle;font-weight:bold" class="text-right">
                                <?php echo $option['id'] ?>
                            </td>
                            <td>
                                <input data-name="<?php echo $option['id'] ?>" type="text"
                                       class="form-control changename" value="<?php echo $option['path'] ?>"/>
                            </td>
                            <td class="text-center" style="vertical-align: middle">
                                <a href="#" data-name="<?php echo $option['id'] ?>" class="remove">Remove</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.form-add').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: 'addpath',
                data: $(this).serializeArray(),
                method: 'post',
            }).done(function () {
                location.reload();
            });
        });
        $('.changename').on('keyup', function () {
            var $this = $(this);
            var val = $this.val();
            var id = $this.attr('data-name');
            $.ajax({
                url: 'changepath',
                data: {
                    id: id,
                    path: val,
                },
                method: 'post',
            });
        });
        $('.remove').click(function () {
            var $this = $(this);
            if (confirm('are you sure?')) {
                $.ajax({
                    url: 'deletepath/' + $this.attr('data-name'),
                    method: 'get'
                }).done(function () {
                    $this.html('deleted');
                })
            }
        });
    });
</script>