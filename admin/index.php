<?php
session_start();


if (!isset($_SESSION['login']) || !isset($_SESSION['password']))
{
	require_once "login.php";
	exit;
}
else
{
	// автозагрузка классов
	function __autoload($name)
	{
        // конвертируем полный путь в пространстве имён с \ в /
        $name = str_replace('\\', '/', $name);

	    require_once($name.'.php');
	}
}

// создадим основной обьект настроек
$site_ini = new \app\classes\Msettings();

// подключаем файл со статическими языковыми константами сайта
$lng = $site_ini->return_settings("ru");
require_once '../language/russian.php';

require_once 'header.php';
require_once 'body.php';
require_once 'footer.php';
?>