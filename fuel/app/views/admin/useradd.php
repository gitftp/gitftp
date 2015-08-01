<div class="col-md-6 col-md-offset-3">
    <h1>Add user</h1>

    <form action="#" method="post">
        <div class="form-group">
            <label for="">username</label>
            <input class="form-control" type="text" name="username" placeholder="username"/>
        </div>
        <div class="form-group">
            <label for="">password</label>
            <input class="form-control" type="text" name="password" placeholder="password"/>
        </div>
        <div class="form-group">
            <label for="">group</label>
            <input type="text" class="form-control" name="group" placeholder="group" value="1"/>
        </div>
        <div class="form-group">
            <label for="">email</label>
            <input type="text" name="email" class="form-control" placeholder="email"/>
        </div>
        <div class="form-group">
            <label for="">project limit</label>
            <input type="text" name="project_limit" class="form-control" placeholder="project limit"/>
        </div>
        <div class="form-group">
            <label for="">verified</label>
            <input type="text" name="verified" class="form-control" placeholder="verified"/>
        </div>
        <div class="form-group">
            <label for="">Send email</label>
            <select name="sendemail" class="form-control" placeholder="verified">
                <option value="no" selected>No</option>
                <option value="new">New user</option>
                <option value="beta">Beta user</option>
            </select>
        </div>

        <button class="btn btn-default" type="submit">Submit</button>
    </form>
</div>
