<form class="form-inline" action="#" method="get">
    <div class="form-group">
        <label for="">Search<?php echo \Input::get('key') ? 'ing' : '' ?> <?php echo \Input::get('key', ''); ?></label>
        <input type="text" name="search" class="form-control" value="<?php echo \Input::get('search', ''); ?>"/>
        <button type="submit" class="btn btn-default">Search</button>
    </div>
    <div class="form-group pull-right">
        <div class="btn-group ">
            <a href="<?php
            echo \Fuel\Core\Uri::create('administrator/manage');
            ?>" class="btn btn-default">Projects</a>
            <a href="<?php
            echo \Fuel\Core\Uri::create('administrator/manage/env');
            ?>" class="btn btn-default">Environments</a>
            <a href="<?php
            echo \Fuel\Core\Uri::create('administrator/manage/records');
            ?>" class="btn btn-default">Records</a>
            <a href="<?php
            echo \Fuel\Core\Uri::create('administrator/manage/ftp');
            ?>" class="btn btn-default">Ftp servers</a>
        </div>
    </div>
</form>
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
                <th colspan="3">

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
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage/env', [], [
                            'search' => $project['id'],
                            'key'    => 'deploy_id'
                        ]);
                        ?>">Env</a>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage/records', [], [
                            'search' => $project['id'],
                            'key'    => 'deploy_id'
                        ]);
                        ?>">Recs</a>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('');
                        ?>">Ftp</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

<?php if (isset($branches)) { ?>

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
                <th colspan="2"></th>
            </tr>
            <?php foreach ($branches as $branch) { ?>
                <tr>
                    <td>
                        <?php echo $branch['id'] ?>
                    </td>
                    <td>
                        <?php echo $branch['deploy_id'] ?>
                    </td>
                    <td>
                        <?php echo $branch['auto'] == 1 ? 'Yes' : 'No' ?>
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
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage', [], [
                            'search' => $branch['deploy_id'],
                            'key'    => 'id'
                        ]);
                        ?>">Proj</a>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage/records', [], [
                            'search' => $branch['id'],
                            'key'    => 'branch_id'
                        ]);
                        ?>">Recs</a>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage/ftp', [], [
                            'search' => $branch['ftp_id'],
                            'key'    => 'id'
                        ]);
                        ?>">Ftp</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

<?php if (isset($records)) { ?>

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
                    Record Type
                </th>
                <th>
                    Status
                </th>
                <th>
                    deployed
                </th>
                <th>
                    date
                </th>
                <th>
                    hash
                </th>
                <th colspan="2">
                </th>
            </tr>
            <?php foreach ($records as $record) { ?>
                <tr>
                    <td>
                        <?php echo $record['id'] ?>
                    </td>
                    <td>
                        <?php
                        switch ($record['record_type']) {
                            case 1:
                                echo 'Sync';
                                break;
                            case 2:
                                echo 'Rollback';
                                break;
                            case 3:
                                echo 'Service Push';
                                break;
                            case 4:
                                echo 'First clone';
                                break;
                            case 0:
                                echo 'Update';
                                break;
                            default:
                                echo $record['record_type'];
                        }

                        ?>
                    </td>
                    <td>
                        <?php

                        switch ($record['status']) {
                            case 1:
                                echo 'Success';
                                break;
                            case 2:
                                echo 'In progess';
                                break;
                            case 3:
                                echo 'In queue';
                                break;
                            case 0:
                                echo 'Failed';
                                break;
                            default:
                                echo $record['status'];
                        }

                        ?>
                    </td>
                    <td>
                        <?php echo $record['amount_deployed'] ?>
                    </td>
                    <td>
                        <?php echo \Date::forge($record['date']) ?>
                    </td>
                    <td>
                        <?php echo $record['hash_before'] . ' - ' . $record['hash'] ?>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage', [], [
                            'search' => $record['deploy_id'],
                            'key'    => 'id'
                        ]);
                        ?>">Proj</a>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage/env', [], [
                            'search' => $record['branch_id'],
                            'key'    => 'id'
                        ]);
                        ?>">Env</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

<?php if (isset($ftps)) { ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            FTP servers
        </div>
        <table class="table table-condensed table-bordered">
            <tr>
                <th>
                    Id
                </th>
                <th>
                    Name
                </th>
                <th>
                    Username
                </th>
                <th>
                    Port
                </th>
                <th>
                    Path
                </th>
                <th>
                    Host
                </th>
                <th>
                    Created
                </th>
                <th colspan="2">
                </th>
            </tr>
            <?php foreach ($ftps as $ftp) { ?>
                <tr>
                    <td>
                        <?php echo $ftp['id'] ?>
                    </td>
                    <td>
                        <?php echo $ftp['name'] ?>
                    </td>
                    <td>
                        <?php echo $ftp['username'] ?>
                    </td>
                    <td>
                        <?php echo $ftp['port'] ?>
                    </td>
                    <td>
                        <?php echo $ftp['path'] ?>
                    </td>
                    <td>
                        <?php echo $ftp['host'] ?>
                    </td>
                    <td>
                        <?php echo $ftp['created_at'] ?>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage/env', [], [
                            'search' => $ftp['id'],
                            'key'    => 'ftp_id'
                        ]);
                        ?>">Env</a>
                    </td>
                    <td class="text-center">
                        <a href="<?php
                        echo \Uri::create('administrator/manage/ftp_test/'.$ftp['id']);
                        ?>" target="_blank">Test</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>
