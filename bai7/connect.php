<?php
$connect = mysqli_connect('localhost', 'root', '', 'tintuc');

if (!$connect) {
    die('Không thể kết nối MySQL: ' . mysqli_connect_error());
}

mysqli_set_charset($connect, 'utf8');
?>
