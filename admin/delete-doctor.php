<?php

require_once '../connection.php';
require_once '../helpers/functions.php';

if (isset($_POST['doctor_id']))
{
    $link = mysqli_connect($host, $user, $password, $db_name);mysqli_query($link, "SET NAMES utf8");

    $doctor_id = $_POST['doctor_id'];
    $doctors = [];
    $returned_html = '';

    $delete_queue = mysqli_query($link, "DELETE FROM queue WHERE doctor_id = '$doctor_id'");
    $delete = mysqli_query($link, "DELETE FROM user WHERE id = '$doctor_id'");

    $doctors_query = mysqli_query($link, "SELECT * FROM user WHERE role_id = 2") or die(mysqli_error($link));

    $doctors = queryToArray($doctors_query);

    foreach ($doctors as $item)
    {
        $returned_html .= '<div class="col-md-12">';
        $returned_html .= '<div class="item clearfix" data-id="' . $item['id'] . '">';
        $returned_html .= '<div class="doctor-info">';
        $returned_html .= '<span class="name">' . $item['name'] . '</span>';
        $returned_html .= '<span class="specialization">' . $item['specialization'] . '</span>';
        $returned_html .= '<span class="cabinet">каб. №' . $item['cabinet'] . '</span>';
        $returned_html .= '</div>';
        $returned_html .= '<div class="action clearfix">';
        $returned_html .= '<a href="view-doctor.php?id='.$item['id'].'" class="open">Открыть профиль</a>';
        $returned_html .= '<a href="" class="delete">Удалить</a>';
        $returned_html .= '</div>';
        $returned_html .= '</div>';
        $returned_html .= '</div>';
    }

    echo $returned_html;
}
else
{
    return false;
}