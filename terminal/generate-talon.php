<?php

require_once '../connection.php';

if (isset($_GET['doctor-id']))
{

    $doctor_id = $_GET['doctor-id'];
    $num = null;
    $people_in_queue = 0;

    $link = mysqli_connect($host, $user, $password, $db_name);mysqli_query($link, "SET NAMES utf8");
    $doctor = mysqli_query($link, "SELECT * FROM User WHERE id = " . $doctor_id)->fetch_assoc() or die(mysqli_error($link));

    $last_in_queue = mysqli_query($link, "SELECT * FROM Queue WHERE status_id = 1 AND doctor_id = " . $doctor_id . " ORDER BY id DESC ") or die(mysqli_error($link));

    if (!empty($last_in_queue = $last_in_queue->fetch_assoc()))
    {
        //Если в очереди есть активные ждуны

        $last_active_num = (int)$last_in_queue['num'];
        $num = $last_active_num + 1;

        //Получиаем кол-во людей в очереди
        $people_in_queue = mysqli_query($link, "SELECT COUNT(*) FROM Queue WHERE status_id = 1 AND doctor_id = " . $doctor_id)->fetch_array() or die(mysqli_error($link));
    }
    else
    {
        $num = 1;
    }

    $cur_date = date('Y-m-d H:i:s');
    $result = mysqli_query($link,"INSERT INTO Queue (doctor_id, num, date, status_id) VALUES ('".$doctor_id."', '".$num."', '".$cur_date."', '1')");
}
else
{
    echo "Пропущен параметр";
    return false;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Печать талона</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/bootstrap-grid.css"/>
    <link rel="stylesheet" href="../css/terminal.css"/>

    <script src="../js/jquery.js"></script>
</head>
<body>

<div class="terminal-page">
    <div class="terminal-print-talon">
        <h1 class="number"><?= $num ?></h1>
        <p class="desc">Ваш номер</p>
        <p class="cabinet"><?= $doctor['specialization'] ?> (каб. №<?= $doctor['cabinet'] ?>)<br><?= $doctor['name'] ?></p>
        <p class="date">Дата получения талона: <?= $cur_date ?></p>
        <p class="queue-info">Человек в очереди: <?= ($people_in_queue[0] == 0 ? 'Кабинет свободен' : $people_in_queue[0]) ?></p>
    </div>
</div>

</body>
</html>
