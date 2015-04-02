<form action="<?php echo Uri::base(false).'user/getfeedbackform'; ?>" method="post">
    <table>
        <tr>
            <td>Name: </td>
            <td><input type="text" name="name" placeholder="Enter Name"></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><input type="text" name="email" placeholder="Enter Email"></td>
        </tr>
        <tr>
            <td>Feedback: </td>
            <td><textarea name="feedback" placeholder="Enter Feedback"></textarea></td>
        </tr>
    </table>
</form>