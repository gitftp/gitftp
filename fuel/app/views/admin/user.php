<form action="#" method="post" class="form-inline">
    <input type="text" class="form-control" name="key" placeholder="find this" value="<?php echo $key; ?>"/>
    <input type="text" class="form-control" name="value" placeholder="where this" value="<?php echo $value; ?>"/>
    <button type="submit" class="btn btn-success">Search</button>
    <a href="<?php echo Uri::create('administrator/user/add'); ?>" class="btn btn-default">add user</a>
</form>
<br/>
<table class="table table-condensed table-bordered">
    <tr>
        <th>ID</th>
        <th>username</th>
        <th>group</th>
        <th>email</th>
        <th>profile fields</th>
        <th>created</th>
        <th>updated</th>
    </tr>
    <?php foreach ($users as $k) { ?>
        <tr>
            <td><?php echo $k['id'] ?></td>
            <td><?php echo $k['username'] ?></td>
            <td><?php echo $k['group'] ?></td>
            <td><?php echo $k['email'] ?></td>
            <td>
                <?php echo $k['profile_fields']; ?>
            </td>
            <td>
                <?php echo Date::forge($k['created_at'])->format("%m/%d/%Y %H:%M"); ?>
            </td>
            <td>
                <?php echo Date::forge($k['updated_at'])->format("%m/%d/%Y %H:%M"); ?>
            </td>
            <td>
                <a onclick="return confirm('sure');" href="<?php echo Uri::create('administrator/user/delete/' . $k['id']); ?>">del</a>
                <br/>
                <a onclick="return confirm('sure');" href="<?php echo Uri::create('administrator/user/resetpassword/' . $k['username']); ?>">resetpass</a>
            </td>
        </tr>
    <?php } ?>
</table>