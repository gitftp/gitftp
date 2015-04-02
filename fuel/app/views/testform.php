<form action="<?php echo Uri::base(false).'welcome/testmulti';?>" method="post" enctype="multipart/form-data">
    <input type="file" multiple="" name="fileint[]" />
    <input type="submit" value="add" />
</form>