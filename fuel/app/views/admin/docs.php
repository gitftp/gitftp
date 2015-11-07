<a class="btn btn-default" href="<?php echo \Uri::create('administrator/docs/index/documentation'); ?>">Show documentation (default)</a>
<a class="btn btn-default" href="<?php echo \Uri::create('administrator/docs/index/getting-started'); ?>">Show getting started</a>
<a class="btn btn-default pull-right" href="<?php echo \Uri::create('administrator/docs/new'); ?>">Create new</a>
<div style="height: 10px;"></div>
<div class="panel panel-default">
    <div class="panel-heading">
        Pages
    </div>
    <table class="table table-bordered table-condensed">
        <tr>
            <th>
                Id
            </th>
            <th>
                Title
            </th>
            <th>
                Slug
            </th>
            <th>
                Content
            </th>
            <th>
                Type
            </th>
            <Th>
                Pos
            </Th>
            <th>
                Published
            </th>
            <th colspan="2"></th>
        </tr>
        <?php foreach ($pages as $page) { ?>
            <tr>
                <td>
                    <?php echo $page['id']; ?>
                </td>
                <td>
                    <?php echo $page['title']; ?>
                </td>
                <td>
                    <?php echo $page['slug']; ?>
                </td>
                <td>
                    <?php echo \Str::truncate(\Security::strip_tags($page['content']), 100); ?>
                </td>
                <td>
                    <?php echo $page['type']; ?>
                </td>
                <td>
                    <input style="width: 40px;" type="number" value="<?php echo $page['position']; ?>" class="changepos" data-id="<?php echo $page['id']; ?>"/>
                </td>
                <td>
                    <input type="checkbox" value="1" class="changepub" data-id="<?php echo $page['id']; ?>" <?php echo $page['published'] == 1 ? 'checked' : ''; ?>/>
                </td>
                <td class="text-center">
                    <a href="<?php echo \Uri::create('administrator/docs/edit/' . $page['id']); ?>">Edit</a>
                </td>
                <td class="text-center">
                    <a href="<?php echo \Uri::create('administrator/docs/delete/' . $page['id']); ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<script>
    $(function () {
        $('.changepos').change(function () {
            var i = $(this).val();
            var id = $(this).attr('data-id');

            $.ajax({
                url: '',
                data: {
                    id: id,
                    position: i
                },
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                console.log(res);
            })
        })
        $('.changepub').change(function () {
            var i = $(this).prop('checked');
            var id = $(this).attr('data-id');
            if (i) {
                i = 1;
            } else {
                i = null;
            }
            $.ajax({
                url: '',
                data: {
                    id: id,
                    published: i
                },
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                console.log(res);
            })
        })
    })
</script>