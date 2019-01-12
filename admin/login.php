<?php
ob_start();
session_start();

// автозагрузка классов	
function __autoload($name)
{
    // конвертируем полный путь в пространстве имён с \ в /
    $name = str_replace('\\', '/', $name);

    require_once($name.'.php');
}
	
if (!isset($_POST['login']) || !isset($_POST['password']) )
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <!--Подключаем таблицу стилей CSS-->
        <link href="../style/login.css" rel="stylesheet" type="text/css" media="screen, all" />
        <!--Конец подключения-->

        <title>Авторизация доступа</title>
    </head>
    <body>
    <div class="form_wrapper">

       <form class="login active" action="login.php" method="post">
        <h3>Авторизация доступа<br /></h3>
        <h2>Вход в систему управления сайтом.</h2>

            <div>
            <label>Логин:</label>
            <input type="text" name="login"/>
            </div>

            <div>
            <label>Пароль:</label>
            <input name="password" type="password" />
            </div>

            <input type="submit" value="Войти" />

        </form>

    </div>

    <?php
    require_once "footer.php";
}
else
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login) || empty($password))
    {
        die("<center><img src='image/error.png' border=0><h4>Вы ввели не всю информацию, вернитесь назад и заполните все поля!</h4><br><a href='index.php'>Назад</a></center>");
    }

    $check_authorisation = \app\classes\Factory::getClassInst("Login");

    $login = $check_authorisation->clean_login($login);
    $password = $check_authorisation->clean_password($password);

    $result = $check_authorisation->return_authorisation($login, $password);

    $authorized = $result->fetch();

    if ($authorized)
    {
        $_SESSION['login'] = $login;

        $_SESSION['password'] = $password;

        header('Location: index.php');
    }

    else
    {

        die("<center><img src='image/error.png' border=0><h4>Ошибка авторизации!</h4><br><a href='index.php'>Назад</a></center>");
    }

}
?>