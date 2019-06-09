<?php

require_once '../connection.php';

if(isset($_GET['doctor-id'])){

    $doctor_id = $_GET['doctor-id'];

    $link = mysqli_connect($host, $user, $password, $db_name);mysqli_query($link, "SET NAMES utf8");
    $doctor = mysqli_query($link, "SELECT * FROM User WHERE id = " . $doctor_id)->fetch_assoc() or die(mysqli_error($link));
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
    <title>Просмотр кабинета</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/bootstrap-grid.css"/>
    <link rel="stylesheet" href="../css/terminal.css"/>

    <script src="../js/jquery.js"></script>
</head>
<body>

<div class="terminal-page">
    <div class="terminal-index">
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title"><?= $doctor['specialization'] ?> (каб. №<?= $doctor['cabinet'] ?>)<br><?= $doctor['name'] ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="action">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="select-doctor.php">
                            <div class="item back">
                                <a href="generate-talon.php?doctor-id=<?= $doctor['id'] ?>" class="name">Печатать талон</a>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-12">
                        <a href="select-doctor.php">
                            <div class="item back">
                                <h2 class="name">Вернуться назад</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
