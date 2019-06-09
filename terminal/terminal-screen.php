<?php

require_once '../connection.php';
require_once '../helpers/functions.php';

if (isset($_GET['doctor-id']))
{

    $doctor_id = $_GET['doctor-id'];
    $doctor_active = false;
    $waiting = true;
    $num = null;
    $queue = [];
    $people_in_queue = 0;

    $link = mysqli_connect($host, $user, $password, $db_name);
    $doctor = mysqli_query($link, "SELECT * FROM User WHERE id = " . $doctor_id)->fetch_assoc() or die(mysqli_error($link));

    if ($doctor['active'] == 1)
    {
        $doctor_active = true;

        $queue_select = mysqli_query($link, "SELECT * FROM Queue WHERE status_id in (1, 2, 3) AND doctor_id = " . $doctor_id . " ORDER BY id ASC") or die(mysqli_error($link));
        $queue = queryToArray($queue_select);

        foreach ($queue as $item)
        {
            //Если есть человек в кабинете
            if ($item['status_id'] == 3)
            {
                $waiting = true;
            }

            if ($item['status_id'] == 2)
            {
                $waiting = false;
            }
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
    <title>Экран терминала</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../css/bootstrap-grid.css"/>
    <link rel="stylesheet" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/terminal.css"/>

    <script src="../js/jquery.js"></script>
    <script src="../js/terminal/terminal-screen.js"></script>
</head>
<body>

<div class="terminal-page">
    <div class="terminal-screen">
        <div class="cabinet-info">
            <h1>Кабинет №<?= $doctor['cabinet'] ?><br><?= $doctor['specialization'] ?>, <?= $doctor['name'] ?></h1>
        </div>
        <div class="queue-info">
            <?php if ($doctor_active): ?>
                <?php if ($waiting): ?>
                    <div class="in-process">
                        <h1>Ожидайте</h1>
                    </div>
                <?php else: ?>
                    <div class="waiting">
                        <h1 class="num"><?= $num ?></h1>
                        <p class="desc">Пациент с талоном №<?= $num ?>, врач ожидает Вас в кабинете</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="not-active">
                    <h1>Кабинет не работает</h1>
                </div>
            <?php endif; ?>
        </div>
        <input type="hidden" name="doctor_id" value="<?= $doctor['id'] ?>">
    </div>
</div>

</body>
</html>
