<?php
session_start();

// отображение ошибок
//ini_set('display_errors', '0');

// автозагрузка классов
spl_autoload_register(function ($name)
{
    // конвертируем полный путь в пространстве имён с \ в /
    $name = str_replace('\\', '/', $name);

    try
    {
        require_once($name.'.php');
    }
    catch (\Exception $exception)
    {
        $error = date("j.m.Y \a\\t G:i:s") . "\nInvalid class name '{$name}'\n\n";
        echo $exception->getMessage() . "\n\n";
        file_put_contents('logs.txt', $error,FILE_APPEND);
    }
});

if (!file_exists("logs.txt"))
{
    header("Location: install.php");
}

// библиотека функций
require_once "lib/functions.php";

// создадим основной обьект настроек
$site_ini = \app\classes\Factory::getClassInst("Msettings");

// опрелелим имя домена
$dom = $site_ini->return_domain();
define ('DOMAINNAME',"$dom[domainname]");

// если выбран язык сайта - заносим его в сессию

// если пользователь зашел впервые
if ($_SESSION['language'] == "")
{
    $lng = $site_ini->return_default_language();

    foreach($lng as $value)
    {
        $_SESSION['language'] = "$value";
    }
}
if ($_GET['lang'] == "ru")
{
    $_SESSION['language']="ru";
}
elseif ($_GET['lang'] == "en")
{
    $_SESSION['language']="en";
}

// в зависимости от выбранного языка подключаем файл со статическими языковыми константами сайта
if ($_SESSION['language'] == "ru")
{
    $lng = $site_ini->return_settings("ru");
    require_once "language/russian.php";
}
elseif($_SESSION['language'] == "en")
{
    $lng = $site_ini->return_settings("en");
    require_once "language/english.php";
}
else
{
    $lng = $site_ini->return_settings("ru");
    require_once "language/russian.php";
}

///////////////////////////////
$os = strtolower($_ENV['OS']);
if(strstr($os,'win'))
{
    $separator = ";";
}
else
{
    $separator = ":";
}
$abs_path = $separator.$_SERVER['DOCUMENT_ROOT'];
ini_set('include_path',ini_get('include_path').$abs_path);