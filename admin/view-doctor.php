<?php

require_once '../connection.php';
require_once '../helpers/functions.php';

session_start();
if (isset($_SESSION['auth']))
{
    $user_id = $_SESSION['id'];
    $link = mysqli_connect($host, $user, $password, $db_name);mysqli_query($link, "SET NAMES utf8");

    $query = "SELECT * FROM user WHERE id = '$user_id'";
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user['role_id'] == 1)
    {
        if (isset($_GET['id']))
        {

            $doctor_id = $_GET['id'];

            $doctor = mysqli_query($link, "SELECT * FROM User WHERE id = " . $doctor_id)->fetch_assoc() or die(mysqli_error($link));

            $queue = mysqli_query($link, "SELECT *, queue.id as queue_id, status.name as status FROM Queue LEFT JOIN status ON status.id = queue.status_id WHERE status_id in (1, 2, 3) AND doctor_id = " . $doctor_id . " ORDER BY queue.id ASC") or die(mysqli_error($link));

            $queue_array = queryToArray($queue);
        }
        else
        {
            echo "Пропущен параметр";
            return false;
        }
    }
    else
    {
        http_response_code(403);
        die('Нет доступа');
    }
}
else
{
    header("Location: /login.php");
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Панель администрирования</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/bootstrap-grid.css"/>
    <link rel="stylesheet" href="../css/account.css"/>

    <script src="../js/jquery.js"></script>
    <script src="../js/account/admin-action.js"></script>
</head>
<body>

<div class="account">
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo">
                        <span class="name">Панель администрирования</span>
                    </div>
                    <div class="links">
                        <ul>
                            <li><a href="../logout.php">Выйти</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="user-info">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span class="name"><?= $user['name'] ?></span>
                    <div class="doctor-info clearfix">
                        <span class="specialization"><?= $user['specialization'] ?></span>
                        <span class="cabinet"><?= $user['cabinet'] ?> кабинет</span>
                    </div>
                    <input type="hidden" name="doctor-id" value="<?= $user['id'] ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="admin-view-doctor">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header">
                        <h1 class="title"><?= $doctor['name'] ?> (<?= $doctor['specialization'] ?>, каб.
                            №<?= $doctor['cabinet'] ?>)</h1>
                        <div class="header-action clearfix">
                            <?php if ($doctor['active'] == 1): ?>
                                <a href="" data-doctor-id="<?= $doctor['id'] ?>" class="no-active">Сделать
                                    неактивным</a>
                            <?php else: ?>
                                <a href="" data-doctor-id="<?= $doctor['id'] ?>" class="active">Сделать активным</a>
                            <?php endif; ?>
                            <a href="edit-doctor.php?id=<?= $doctor['id'] ?>" class="edit">Редактировать</a>
                            <a href="index.php" class="back">Назад</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="doctor-queue-info">
                <div class="row">
                    <?php if (!empty($queue_array)): ?>
                        <?php foreach ($queue_array as $item): ?>
                            <div class="col-md-12">
                                <div class="item clearfix" data-id="<?= $item['queue_id'] ?>">
                                    <span class="talon-number">Талон №<?= $item['num'] ?></span>
                                    <span class="status"><?= $item['status'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-12">
                            <p>Очередь пуста</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</body>
</html>
