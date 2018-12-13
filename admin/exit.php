<?php
session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['password']))
{
	exit ("Доступ на эту страницу разрешен только администратору сайта<br><a href='http://www.clubintellect.ru/admin/index.php'>Главная страница</a>");
}


unset($_SESSION['login']); 
unset($_SESSION['password']);

header('Refresh: 0; URL=../');

exit;
?>