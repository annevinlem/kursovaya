<?php

require_once '../connection.php';

if (isset($_POST['doctor_id']))
{
    $doctor_id = $_POST["doctor_id"];

    $doctor_active = false;
    $waiting = true;
    $in_process = false;
    $num = null;
    $queue = [];
    $people_in_queue = 0;

    $return_html = '';

    $link = mysqli_connect($host, $user, $password, $db_name);
    $doctor = mysqli_query($link, "SELECT * FROM User WHERE id = " . $doctor_id)->fetch_assoc() or die(mysqli_error($link));

    if ($doctor['active'] == 1)
    {
        $doctor_active = true;

        $queue_select = mysqli_query($link, "SELECT * FROM Queue WHERE status_id in (1, 2, 3) AND doctor_id = " . $doctor_id . " ORDER BY id ASC") or die(mysqli_error($link));

        while ($row = $queue_select->fetch_assoc())
        {

            //Если есть человек в кабинете
            if ($row['status_id'] == 3)
            {
                $in_process = true;
                $waiting = false;
            }

            if ($row['status_id'] == 2)
            {
                $waiting = false;
                $in_process = false;

            }

            $queue[] = $row;
        }

        if (empty($queue))
        {
            //Если очередь пуста

            $waiting = true;
        }
        else
        {
            //Если в очереди есть люди

            if ($waiting == false)
            {
                $num = $queue[0]['num'];
            }
        }
    }
    else
    {
        $doctor_active = false;
    }

    if ($doctor_active)
    {
        if ($in_process)
        {
            $return_html .= '<div class="in-process">';
            $return_html .= '<h1>Ведётся прием</h1>';
            $return_html .= '</div>';
        }
        elseif ($waiting)
        {
            $return_html .= '<div class="in-process">';
            $return_html .= '<h1>Ожидайте</h1>';
            $return_html .= '</div>';
        }
        else
        {
            $return_html .= '<div class="waiting">';
            $return_html .= '<h1 class="num">' . $num . '</h1>';
            $return_html .= '<p class="desc">Пациент с талоном №' . $num . ', врач ожидает Вас в кабинете</p>';
            $return_html .= '</div>';
        }
    }
    else
    {
        $return_html .= '<div class="not-active">';
        $return_html .= '<h1>Кабинет не работает</h1>';
        $return_html .= '</div>';
    }

    echo $return_html;

}
else
{
    return false;
}