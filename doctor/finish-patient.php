<?php

require_once '../connection.php';
require_once '../helpers/functions.php';

if (isset($_POST['queue_id']) && isset($_POST['doctor_id']))
{
    $link = mysqli_connect($host, $user, $password, $db_name);

    $queue_id = $_POST['queue_id'];
    $doctor_id = $_POST['doctor_id'];
    $queue_array = [];
    $block_action = false;

    $update = mysqli_query($link, "UPDATE queue SET status_id = '4' WHERE id = " . $queue_id);
    $queue = mysqli_query($link, "SELECT *, queue.id as queue_id, status.name as status FROM Queue LEFT JOIN status ON status.id = queue.status_id WHERE status_id in (1, 2, 3) AND doctor_id = " . $doctor_id . " ORDER BY queue.id ASC") or die(mysqli_error($link));

    $queue_array = queryToArray($queue);

    foreach ($queue_array as $item)
    {
        if ($item['status_id'] == 2 || $item['status_id'] == 3)
        {
            $block_action = true;
        }
    }

    echo queueToHtml($queue_array, $block_action);
}
else
{
    return false;
}