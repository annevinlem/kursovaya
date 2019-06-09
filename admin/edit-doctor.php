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
        if (isset($_GET['id']))
        {

            $doctor_id = $_GET['id'];
            $doctor = mysqli_query($link, "SELECT * FROM User WHERE id = " . $doctor_id)->fetch_assoc() or die(mysqli_error($link));

            if (isset($_POST['save-doctor']))
            {
                if ($_POST['password'] != null)
                {
                    $query = "UPDATE user SET login = '" . $_POST['login'] . "', password = '" . md5($_POST['password']) . "', name = '" . $_POST['name'] . "', specialization = '" . $_POST['specialization'] . "', cabinet = '" . $_POST['cabinet'] . "' WHERE id = " . $doctor_id;
                    $update = mysqli_query($link, $query);
                }
                else
                {
                    $query = "UPDATE user SET login = '" . $_POST['login'] . "', name = '" . $_POST['name'] . "', specialization = '" . $_POST['specialization'] . "', cabinet = '" . $_POST['cabinet'] . "' WHERE id = " . $doctor_id;
                    $update = mysqli_query($link, $query) or die(mysqli_error($link));
                }

                header("Location: view-doctor.php?id=" . $doctor_id);
            }
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
    <div class="admin-edit-doctor">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header">
                        <h1 class="title">Редактирование врача</h1>
                        <div class="header-action clearfix">
                            <a href="index.php" class="back">Назад</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="doctor-form">
                <div class="row">
                    <div class="col-md-6">
                        <form action="edit-doctor.php?id=<?= $doctor['id'] ?>" method="post">
                            <label for="login">Лоигн</label>
                            <input required type="text" value="<?= $doctor['login'] ?>" name="login"
                                   placeholder="user-login">
                            <label for="login">Новый пароль</label>
                            <input type="text" name="password" placeholder="Новый пароль">
                            <label for="login">Имя фамилия</label>
                            <input required type="text" value="<?= $doctor['name'] ?>" name="name"
                                   placeholder="Анич Стародубчик">
                            <label for="login">Специализация</label>
                            <input required type="text" value="<?= $doctor['specialization'] ?>" name="specialization"
                                   placeholder="Стоматолог">
                            <label for="login">Номер кабинета</label>
                            <input required type="text" value="<?= $doctor['cabinet'] ?>" name="cabinet"
                                   placeholder="23">
                            <input required type="submit" name="save-doctor" value="Сохранить изменения">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
