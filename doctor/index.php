<?php

require_once '../connection.php';
require_once '../helpers/functions.php';

session_start();
if (isset($_SESSION['auth']))
{
    $doctor_id = $_SESSION['id'];
    $link = mysqli_connect($host, $user, $password, $db_name);

    $query = "SELECT * FROM user WHERE id = '$doctor_id'";
    $result = mysqli_query($link, $query);
    $doctor = mysqli_fetch_assoc($result);

    if ($doctor['role_id'] == 2)
    {
        $queue_array = [];
        $block_action = false;

        $queue = mysqli_query($link, "SELECT *, queue.id as queue_id, status.name as status FROM Queue LEFT JOIN status ON status.id = queue.status_id WHERE status_id in (1, 2, 3) AND doctor_id = " . $doctor_id . " ORDER BY queue.id ASC") or die(mysqli_error($link));

        $queue_array = queryToArray($queue);

        foreach ($queue_array as $item)
        {
            if ($item['status_id'] == 2 || $item['status_id'] == 3)
            {
                $block_action = true;
            }
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
    <title>Личный кабинет врача</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/bootstrap-grid.css"/>
    <link rel="stylesheet" href="../css/account.css"/>

    <script src="../js/jquery.js"></script>
    <script src="../js/account/queue-action.js"></script>
</head>
<body>

<div class="account">
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo">
                        <span class="name"></span>
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
                    <span class="name"><?= $doctor['name'] ?></span>
                    <div class="doctor-info clearfix">
                        <span class="specialization"><?= $doctor['specialization'] ?></span>
                        <span class="cabinet"><?= $doctor['cabinet'] ?> кабинет</span>
                    </div>
                    <input type="hidden" name="doctor-id" value="<?= $doctor['id'] ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="doctor-index">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header">
                        <h1 class="title">Текущая загруженность</h1>
                    </div>
                </div>
            </div>

            <div class="queue-list">
                <div class="row">
                    <div class="queue-list-ajax">
                        <?php if (!empty($queue_array)): ?>
                            <?php foreach ($queue_array as $item): ?>
                                <div class="col-md-12">
                                    <div class="item clearfix" data-id="<?= $item['queue_id'] ?>">
                                        <span class="talon-number">Талон №<?= $item['num'] ?></span>
                                        <span class="status"><?= $item['status'] ?></span>
                                        <div class="action clearfix <?= ($block_action && $item['status_id'] == 1 ? 'block' : '') ?>">
                                            <?php if ($item['status_id'] == 1): ?>
                                                <span class="invite">Пригласить пациента</span>
                                            <?php elseif ($item['status_id'] == 2): ?>
                                                <span class="come">Пациент пришёл</span>
                                                <span class="not_come">Пациент не пришёл</span>
                                            <?php elseif ($item['status_id'] == 3): ?>
                                                <span class="end">Закончить прием</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-md-12">
                                <p>Очереди нет</p>
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
