<?php

require_once 'connection.php';

$error = [];

if (!empty($_REQUEST['password']) and !empty($_REQUEST['login']))
{
    $link = mysqli_connect($host, $user, $password, $db_name);mysqli_query($link, "SET NAMES utf8");

    //Пишем логин и пароль из формы в переменные (для удобства работы):
    $login = $_REQUEST['login'];
    $password = md5($_REQUEST['password']);

    $query = "SELECT * FROM user WHERE login = '$login' AND password = '$password'";
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);

    //Если база данных вернула не пустой ответ - значит пара логин-пароль правильная
    if (!empty($user))
    {
        //Пользователь прошел авторизацию

        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['id'] = $user['id'];

        if ($user['role_id'] == 1)
        {
            //Если это администратор
            header("Location: /admin");
        }
        else
        {
            //Если это врач
            header("Location: /doctor");
        }
    }
    else
    {
        //Пользователь неверно ввел логин или пароль, выполним какой-то код.
        $error['reason'] = 'Пользователь не найден';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Авторизация</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/login/util.css">
    <link rel="stylesheet" type="text/css" href="css/login/login.css">

</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-85 p-b-20">
            <form class="login100-form validate-form" action="login.php" method="post">
					<span class="login100-form-title p-b-70">
						Авторизация
					</span>
                <span class="login100-form-avatar">
						<img src="image/login-logo.png">
					</span>

                <div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate="Логин">
                    <input class="input100" type="text" name="login">
                    <span class="focus-input100" data-placeholder="Логин"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-50" data-validate="Пароль">
                    <input class="input100" type="password" name="password">
                    <span class="focus-input100" data-placeholder="Пароль"></span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Войти
                    </button>
                    <?php if (!empty($error)): ?>
                        <span class="error m-t-20"><?= $error['reason'] ?></span>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>