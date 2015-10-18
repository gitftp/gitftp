<table class="table table-condensed">
    <tr>
        <th>
            ID
        </th>
        <th>
            User_id
        </th>
        <th>
            Username
        </th>
        <th style="width: 30%">
            Feedback
        </th>
        <th>
            Date
        </th>
    </tr>

    <?php foreach ($feedback as $f) { ?>

        <tr>
            <td>
                <?php echo $f['id']; ?>
            </td>
            <td>
                <?php echo $f['user_id']; ?>
            </td>
            <td>
                <a href="<?php echo Uri::create('administrator/user', array(), array(
                    'value' => $f['user_id']
                )) ?>"><?php echo $f['username']; ?></a>
            </td>
            <td>
                <?php echo $f['message']; ?>
            </td>
            <td>
                <?php echo Date::forge($f['date'])->format('%m/%d/%Y %H:%M'); ?>
            </td>
            <td>
                <span class="delete" data-id="<?php echo $f['id']; ?>">Delete</span>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
    $('span.delete').click(function () {
        if (!confirm('sure?'))
            return false;

        var id = $(this).attr('data-id');
        $.get('delete/' + id, function (data) {
            alert(data);
        })
    });
</script>