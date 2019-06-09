<?php

require_once '../connection.php';
require_once '../helpers/functions.php';

$link = mysqli_connect($host, $user, $password, $db_name);

$cabinets_query = mysqli_query($link, "SELECT * FROM User WHERE role_id = 2") or die(mysqli_error($link));
$cabinets = queryToArray($cabinets_query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Выберите кабинет</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../css/bootstrap-grid.css"/>
    <link rel="stylesheet" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/terminal.css"/>

    <script src="../js/jquery.js"></script>
    <script src="../js/terminal/terminal-screen.js"></script>
</head>
<body>

<div class="terminal-page">
    <div class="terminal-index">
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title">Выберите кабинет</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="select">
            <div class="container">
                <div class="row">
                    <?php foreach($cabinets as $item): ?>
                        <div class="col-md-6">
                            <a href="terminal-screen.php?doctor-id=<?= $item['id'] ?>">
                                <div class="item">
                                    <h2 class="name"><?= $item['specialization'] ?></h2>
                                    <span class="desc">Кабинет: <?= $item['cabinet'] ?>, <?= $item['name'] ?></span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="action">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="/">
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
