<?php

require_once '../connection.php';

session_start();
if (isset($_SESSION['auth']))
{
    $user_id = $_SESSION['id'];
    $link = mysqli_connect($host, $user, $password, $db_name);

    $query = "SELECT * FROM user WHERE id = '$user_id'";
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user['role_id'] == 1)
    {
        if (isset($_POST['save-doctor']))
        {
            $query = "INSERT INTO user VALUES ('','" . $_POST['login'] . "','" . md5($_POST['password']) . "','" . $_POST['name'] . "','" . $_POST['specialization'] . "','" . $_POST['cabinet'] . "', '1', '2')";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));

            header("Location: index.php");
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
                        <span class="cabinet"> Кабинет: <?= $user['cabinet'] ?></span>
                    </div>
                    <input type="hidden" name="doctor-id" value="<?= $user['id'] ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="admin-add-doctor">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header">
                        <h1 class="title">Добавление врача</h1>
                        <div class="header-action clearfix">
                            <a href="index.php" class="back">Назад</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="doctor-form">
                <div class="row">
                    <div class="col-md-6">
                        <form action="add-doctor.php" method="post">
                            <label for="login">Логин</label>
                            <input required type="text" value="<?= $doctor['login'] ?>" name="login" placeholder="admin">
                            <label for="login">Пароль</label>
                            <input required type="text" name="password" placeholder="password">
                            <label for="login">ФИО</label>
                            <input required type="text" value="<?= $doctor['name'] ?>" name="name" placeholder="Стародуб Анна Романовна">
                            <label for="login">Специализация врача</label>
                            <input required type="text" value="<?= $doctor['specialization'] ?>" name="specialization" placeholder="Администратор">
                            <label for="login">Номер кабинета</label>
                            <input required type="text" value="<?= $doctor['cabinet'] ?>" name="cabinet" placeholder="1">
                            <input required type="submit" name="save-doctor" value="Добавить доктора">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
