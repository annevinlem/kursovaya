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
        $doctors = [];

        $doctors_query = mysqli_query($link, "SELECT * FROM user WHERE role_id = 2") or die(mysqli_error($link));

        $doctors = queryToArray($doctors_query);
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
    <div class="admin-index">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header">
                        <h1 class="title">Список врачей</h1>
                        <div class="header-action clearfix">
                            <a href="add-doctor.php" class="add">Добавить врача</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="doctor-list">
                <div class="row">
                    <div class="doctor-list-ajax">
                        <?php if (!empty($doctors)): ?>
                            <?php foreach ($doctors as $item): ?>
                                <div class="col-md-12">
                                    <div class="item clearfix" data-id="<?= $item['id'] ?>">
                                        <div class="doctor-info">
                                            <span class="name"><?= $item['name'] ?></span>
                                            <span class="specialization"><?= $item['specialization'] ?></span>
                                            <span class="cabinet">каб. №<?= $item['cabinet'] ?></span>
                                        </div>
                                        <div class="action clearfix">
                                            <a href="view-doctor.php?id=<?= $item['id'] ?>" class="open">Открыть профиль</a>
                                            <a href="" class="delete">Удалить</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-md-12">
                                <p>Нет врачей</p>
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
