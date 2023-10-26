<?php if (empty($files)) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Log listing
        </div>
        <table class="table table-bordered table-condensed">
            <tr>
                <th>Filename</th>
                <th class="text-right">Action</th>
            </tr>

            <?php foreach ($log as $k => $l) {
                foreach ($l as $_k => $_l) {
                    ?>
                    <tr>
                        <td>
                            <?php print_r(DOCROOT . 'fuel/app/log/' . $k . $_l); ?>
                        </td>
                        <td class="text-right">
                            <a href="<?php
                            echo \Fuel\Core\Uri::create('administrator/log', [],
                                array('file' => $k . $_l)
                            );
                            ?>">View</a>
                        </td>
                    </tr>
                <?php
                }
            } ?>
        </table>
    </div>
<?php } else { ?>
    <?php
    if (\Input::get('rev', 0)) {
        $s = \Uri::update_query_string(array('rev' => 0));
    } else {
        $s = \Uri::update_query_string(array('rev' => 1));
    }
    ?>
    Log is <strong><?php echo \Input::get('rev', 0) ? 'new to old' : 'old to new' ?></strong>
    <a href="<?php echo $s ?>" class="btn btn-default pull-right">Reverse log</a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <kbd>
                    <?php foreach ($files as $f) { ?>
                        <?php if (!empty($f)) {
                            echo $f . '<br>';
                        } ?>
                    <?php } ?>
                </kbd>
            </div>
        </div>
    </div>
<?php } ?>
<br/><br/><br/><br/><br/>