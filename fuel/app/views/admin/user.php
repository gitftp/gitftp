<form action="#" method="get" class="form-inline">
    <input type="text" class="form-control" name="key" placeholder="find this" value="<?php echo $key; ?>"/>
    <input type="text" class="form-control" name="value" placeholder="where this" value="<?php echo $value; ?>"/>
    <button type="submit" class="btn btn-success">Search</button>
    <a href="<?php echo Uri::create('administrator/user/add'); ?>" class="btn btn-default pull-right">add user</a>

    <div class="clearfix"></div>
</form>
<br/>
<table class="table table-condensed">
    <tr>
        <th>V</th>
        <th>Repo_l</th>
        <th>ID</th>
        <th>username</th>
        <th>group</th>
        <th>email</th>
        <th>created</th>
        <th>updated</th>
        <th></th>
    </tr>
    <?php foreach ($users as $k) { ?>
        <tr>
            <td><?php echo $k['verified'] ?></td>
            <td><?php echo $k['repol'] ?></td>
            <td><?php echo $k['id'] ?></td>
            <td><?php echo $k['username'] ?></td>
            <td><?php echo $k['group'] ?></td>
            <td><?php echo $k['email'] ?></td>
            <td>
                <?php echo Date::forge($k['created_at'])->format("%m/%d/%Y %H:%M"); ?>
            </td>
            <td>
                <?php echo Date::forge($k['updated_at'])->format("%m/%d/%Y %H:%M"); ?>
            </td>
            <td>
                <a onclick="return confirm('sure');" href="<?php echo Uri::create('administrator/user/delete/' . $k['username']); ?>">del</a>
                &bull;
                <a onclick="return confirm('sure');" href="<?php echo Uri::create('administrator/user/resetpassword/' . $k['username']); ?>">resetpass</a>
                &bull;
                <a href="<?php echo Uri::create('administrator/user/edituser/' . $k['id']); ?>">edit</a>
            </td>
        </tr>
    <?php } ?>
</table>