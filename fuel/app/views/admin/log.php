<ul>
    <?php foreach ($log as $k => $l) { ?>
        <li>
            <?php print_r(DOCROOT . 'fuel/app/log/' . $k . $l[0]); ?> --
            <a href="<?php
            echo \Fuel\Core\Uri::create('administrator/log', [],
                array('file' => $k . $l[0])
            );
            ?>">View</a>
        </li>
    <?php } ?>
</ul>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <code>
                <?php echo $files; ?>
            </code>
        </div>
    </div>
</div>
<br/><br/><br/><br/><br/>