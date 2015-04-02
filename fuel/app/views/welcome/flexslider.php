<div class="flexslider">
    <ul class="slides">
        <?php
        $a = DOCROOT . 'assets/img/slides';
        $d = File::read_dir($a);
        foreach ($d as $value) {
            ?>
            <li>
                <?php echo Asset::img('slides/' . $value); ?>
            </li>
            <?php
        }
        ?>

    </ul>
</div>