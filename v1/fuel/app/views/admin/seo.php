<form class="form-inline" action="#" method="get">
    <div class="form-group">
        <label for="">Search</label>
        <input type="text" name="search" class="form-control" value="<?php echo \Input::get('search', ''); ?>"/>
        <button type="submit" class="btn btn-default">Search</button>
    </div>
    <div class="form-group">
        <a class="btn btn-success pull-right" href="<?php
        echo \Fuel\Core\Uri::create('administrator/seo/create')
        ?>">Create</a>
    </div>
</form>

<br/>
<div class="panel panel-default">
    <div class="panel-heading">
        SEO records
    </div>
    <table class="table table-condensed table-bordered">
        <tr>
            <th>
                ID
            </th>
            <th>
                Path
            </th>
            <th>
                title
            </th>
            <th>
                description
            </th>
            <th>
                keywords
            </th>
            <th colspan="2">
            </th>
        </tr>
        <?php foreach ($list as $d) { ?>
            <tr data-id="<?php echo $d['id']; ?>">
                <td>
                    <?php echo $d['id']; ?>
                </td>
                <td>
                    <input class="form-control" type="text" data-name="path" value="<?php echo $d['path'] ?>"/>
                </td>
                <td>
                    <input class="form-control" type="text" data-name="title" value="<?php echo $d['data']['title'] ?>"/>
                </td>
                <td>
                    <textarea class="form-control" data-name="description"><?php echo $d['data']['description'] ?></textarea>
                </td>
                <td>
                    <textarea class="form-control" data-name="keywords"><?php echo $d['data']['keywords'] ?></textarea>
                </td>

                <td class="text-center">
                    <a href="<?php
                    echo Uri::create('administrator/seo/edit/' . $d['id'])
                    ?>">Edit</a>
                </td>
                <td class="text-center">
                    <a onclick="return confirm('delete, are you sure?')" href="<?php
                    echo Uri::create('administrator/seo/delete/' . $d['id'])
                    ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<style>
    textarea{
        resize: vertical;
    }
</style>
<script>
    $(function(){
        $('[data-name]').keyup(function(){
            var id = $(this).parents('tr').attr('data-id');
            var name = $(this).attr('data-name');
            var val = $(this).val();

            $.ajax({
                url: '',
                method:'post',
                dataType: 'json',
                data: {
                    id: id,
                    name: name,
                    val: val,
                }
            }).done(function(res){
                console.log(res);
            });
        });
    })
</script>