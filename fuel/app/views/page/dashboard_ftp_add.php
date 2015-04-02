<?php echo View::forge('layout/dash_nav'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>
                FTP servers
                <a class="btn btn-default pull-right" href="<?php echo Uri::base(false); ?>dashboard/ftp">List servers</a>
            </h3>
        </div>
    </div>
</div>
<div style="height:10px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <p>Add a FTP server</p>
                    <form id="ftpadd" action="<?php echo Uri::base(false); ?>dashboard/ftp/add" method="post">
                        <div class="form-group">
                            <label for="host">Host</label>
                            <input type="text" class="form-control" name="host" placeholder="domain.com" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="FTP username" required>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="text" class="form-control" name="pass" placeholder="FTP password" required>
                        </div>
                        <div class="form-group">
                            <label for="Scheme">Scheme</label>
                            <input type="text" class="form-control" name="scheme" placeholder="FTP, SFTP, FTPS" required>
                        </div>
                        <div class="form-group">
                            <label for="port">Port no.</label>
                            <input type="text" class="form-control" name="port" placeholder="Port no." required>
                        </div>
                        <div class="form-group">
                            <label for="port">Directory</label>
                            <input type="text" class="form-control" name="path" placeholder="Path from root. /public_html/example" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>