<?php

require_once 'connection.php';

session_start();
unset($_SESSION['auth']);
session_destroy();
header('Location: login.php');