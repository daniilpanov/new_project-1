<?php
namespace app\classes;

class Msettings
{
    // возвращает название домена
	function return_domain()
	{
        $sql = "SELECT domainname  FROM constants WHERE id = :id";
		$dom = Db::getInstance()->sql($sql, array("id" => 1));// выполняем запрос
		$res = $dom->fetch();
        return $res;
    }

	// возвращает настройки сайта для языковых констант
	function return_settings($lng)
	{
		$sql = "SELECT site, footer FROM constants WHERE language = '".$lng."'";
		$lgs = Db::getInstance()->sql($sql);// выполняем запрос
		$res = $lgs->fetch();
        return $res;
	}	
	
	// проверяет включен ли язык на сайте
	function return_active_language()
	{
		$sql = "SELECT visible FROM languages WHERE language != :lang";
		$lgs = Db::getInstance()->sql($sql, array("lang" => $_SESSION['language']));// выполняем запрос
		$res = $lgs->fetch();
		return $res;
	}
		
	// проверяет язык на сайте по умолчанию
	function return_default_language()
	{
		$sql = "SELECT language FROM languages  WHERE default_lng = :lng";
		$lgs = Db::getInstance()->sql($sql, array("lng" => '1'));// выполняем запрос
		$res = $lgs->fetch();
		return $res;
	}
}
?>