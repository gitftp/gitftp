<?php echo View::forge('layout/dash_nav'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>
                FTP servers
                <a class="btn btn-default pull-right" href="<?php echo Uri::base(false); ?>dashboard/ftp/add">Add server</a>
            </h3>
        </div>
    </div>
</div>
<div style="height:10px;"></div>
<?php
if (count($ftp) > 0) {
//    print_r($ftp);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed table-striped">
                    <tr>
                        <th>
                            Host
                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            Password
                        </th>
                        <th>
                            Port no.
                        </th>
                        <th>
                            Directory
                        </th>
                        <th>
                            Scheme
                        </th>
                        <th>
                            actions
                        </th>
                    </tr>
                    <?php foreach ($ftp as $key => $value) { ?>
                        <tr>
                            <td>
                                <p class="text-success"><?php echo $value['host'] ?></p>
                            </td>
                            <td>
                                <?php echo $value['username'] ?>
                            </td>
                            <td>
                                <?php echo $value['pass'] ?>
                            </td>
                            <td>
                                <?php echo $value['port'] ?>
                            </td>
                            <td>
                                <?php echo $value['path'] ?>
                            </td>
                            <td>
                                <?php echo $value['scheme'] ?>
                            </td>
                            <td>
                                <a href="#" class="deleteftp btn btn-warning" data-id="<?php echo $value['id']; ?>">delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <?php
} else {
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br><br><br>
                <h3 class="text-center">No servers added</h3>
            </div>
        </div>
    </div>
    <?php
}
?>

