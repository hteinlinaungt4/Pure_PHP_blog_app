<?php
$db=mysqli_connect('localhost','root','','blog');
if ($db == false) {
    die("Error:".mysqli_connect_error($db));
}