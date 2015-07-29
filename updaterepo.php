<?php

return false;

exec('git pull', $op);

if (isset($_GET['hash']))
    exec('git checkout ' . $_GET['hash'], $op);

echo '<pre>';
print_r($op);
echo 'done';