Hello <?php echo ucfirst($username); ?>,
<br/><br/>
You recently requested to reset your password, <br/>
please click on the link below and you will be requested to enter your new password.
<br/><br/>
<center>
    <a target="_blank" href="<?php echo $resetlink; ?>">Reset password</a>
</center>
<br/><br/>
<small>
    If you did not request for a password reset, ignore this email.
</small>
