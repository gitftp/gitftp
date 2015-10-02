Hello <?php echo $username; ?>,
<br/><br/>
You recently requested for a password reset, <br/>
please click on the link below and you will be requested to enter your new password.
<br/><br/>
<center>
    <a target="empty" href="<?php echo $resetlink; ?>">Reset password</a>
</center>
<br/><br/>
<small>
    If you did not request for a password reset, ignore this email.
</small>
