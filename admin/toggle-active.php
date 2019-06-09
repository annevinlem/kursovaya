<?php

require_once '../connection.php';
require_once '../helpers/functions.php';

if (isset($_POST['doctor_id']))
{
    $link = mysqli_connect($host, $user, $password, $db_name);mysqli_query($link, "SET NAMES utf8");

    $doctor_id = $_POST['doctor_id'];
    $active = $_POST['active'];

    $toggle = mysqli_query($link, "UPDATE user SET active = '$active' WHERE id = '$doctor_id'") or die(mysqli_error($link));

    return true;
}
else
{
    return false;
}