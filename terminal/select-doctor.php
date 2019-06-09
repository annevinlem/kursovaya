<?php

require_once '../connection.php';

$link = mysqli_connect($host, $user, $password, $db_name);

$doctors = mysqli_query($link, "SELECT * FROM User WHERE role_id = 2 AND active = 1") or die(mysqli_error($link));

?>

<!DOCTYPE html>
<html>
<head>
    <title>Выбор направления</title>
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
                        <h1 class="title">Выберите врача</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="select">
            <div class="container">
                <div class="row">
                    <?php while ($doctor = mysqli_fetch_array($doctors)): ?>
                        <div class="col-md-6">
                            <a href="doctor.php?doctor-id=<?= $doctor['id'] ?>">
                                <div class="item">
                                    <h2 class="name"><?= $doctor['specialization'] ?></h2>
                                    <br class="desc"> <?= $doctor['name'] ?> <br> Кабинет: <?= $doctor['cabinet'] ?></br> </span>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <div class="action">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="terminal.html">
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
