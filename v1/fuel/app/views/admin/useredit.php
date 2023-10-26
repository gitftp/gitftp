<div class="col-md-6 col-md-offset-3">
    <h1>edit user</h1>

    <form action="#" method="post">
        <div class="form-group">
            <label for="">Project limit</label>
            <input class="form-control" type="text" name="project_limit" placeholder="repo_limit" value="<?php echo $project_limit; ?>"/>
        </div>
        <div class="form-group">
            <label for="">Verified ?</label>
            <input class="form-control" type="text" name="verified" placeholder="verified" value="<?php echo $verified; ?>"/>
        </div>

        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>