<form class="form-inline" action="#" method="get">
    <div class="form-group">
        <label for="">Search</label>
        <input type="text" name="search" class="form-control" value="<?php echo \Input::get('search', ''); ?>"/>
        <button type="submit" class="btn btn-default">Search</button>
    </div>
</form>
<br/>

<div class="btn-group btn-group-justified">
    <a href="<?php
    echo \Fuel\Core\Uri::create('administrator/manage');
    ?>" class="btn btn-default">Projects</a>
    <a href="<?php
    echo \Fuel\Core\Uri::create('administrator/manage/env');
    ?>" class="btn btn-default">Environments</a>
    <a href="<?php
    echo \Fuel\Core\Uri::create('administrator/manage/records');
    ?>" class="btn btn-default">Records</a>
</div>

<br/>

<?php if (isset($projects)) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Projects
        </div>
        <table class="table table-condensed table-bordered">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Name
                </th>
                <th>
                    Repository
                </th>
                <th>
                    User
                </th>
                <th>
                    Active
                </th>
                <th>
                    Git name
                </th>
                <th>
                    Date created
                </th>
            </tr>
            <?php foreach ($projects as $k => $project) { ?>
                <tr>
                    <td>
                        <?php echo $project['id'] ?>
                    </td>
                    <td>
                        <?php echo $project['name'] ?>
                    </td>
                    <td>
                        <?php echo $project['repository'] ?>
                    </td>
                    <td>
                        <a href="<?php
                        echo \Fuel\Core\Uri::create('administrator/user', [], [
                            'value' => $project['user_id']
                        ]);
                        ?>"><?php echo $project['user_id'] ?> </a>
                    </td>
                    <td>
                        <?php echo $project['active'] ?>
                    </td>
                    <td>
                        <?php echo $project['git_name'] ?>
                    </td>
                    <td>
                        <?php echo $project['created_at'] ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

<?php if(isset($branches)){ ?>

<div class="panel panel-default">
    <div class="panel-heading">
        Environments
    </div>
    <table class="table table-condensed table-bordered">
        <tr>
            <th>
                Id
            </th>
            <th>
                Deploy id
            </th>
            <th>
                Auto deploy
            </th>
            <th>
                Branch name
            </th>
            <th>
                Ftp_id
            </th>
            <th>
                Name
            </th>
        </tr>
        <?php foreach($branches as $branch){ ?>
            <tr>
                <td>
                    <?php echo $branch['id'] ?>
                </td>
                <td>
                    <?php echo $branch['deploy_id'] ?>
                </td>
                <td>
                    <?php echo $branch['auto'] ?>
                </td>
                <td>
                    <?php echo $branch['branch_name'] ?>
                </td>
                <td>
                    <?php echo $branch['ftp_id'] ?>
                </td>
                <td>
                    <?php echo $branch['name'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php } ?>
