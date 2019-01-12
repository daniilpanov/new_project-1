<?php
session_start();

if (!isset($_SESSION['loged']))
{
	exit ("Доступ на эту страницу разрешен только администратору сайта<br><a href='http://www.clubintellect.ru/admin/index.php'>Главная страница</a>");
}


unset($_SESSION['loged']);

header('Refresh: 0; URL=../');

exit;
?>