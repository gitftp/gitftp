<div class="col-md-6 col-md-offset-3">
    <form action="<?php echo Uri::create('administrator/seo/create') ?>" method="POST">
        <?php if (isset($list)) { ?>
            <input type="hidden" value="<?php echo $list['id']; ?>" name="id"/>
        <?php } ?>
        <div class="form-group">
            <label for="">
                Path
            </label>
            <input type="text" name="path" placeholder="Enter path / " class="form-control" value="<?php echo isset($list) ? $list['path'] : '' ?>"/>
        </div>
        <div class="form-group">
            <label for="">
                Page title
            </label>
            <input type="text" name="content[title]" placeholder="" class="form-control" value="<?php echo isset($list) ? $list['data']['title'] : '' ?>"/>
        </div>
        <div class="form-group">
            <label for="">
                Description
            </label>
            <textarea class="form-control" name="content[description]" id="" cols="30" rows="10"><?php echo isset($list) ? $list['data']['description'] : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="">
                keywords
            </label>
            <input type="text" name="content[keywords]" class="form-control" value="<?php echo isset($list) ? $list['data']['keywords'] : '' ?>"/>
        </div>
        <button class="btn btn-success"><?php echo isset($list) ? 'Save' : 'Create' ?></button>
    </form>
</div>
<br/>
<br/>
<br/>
<br/>