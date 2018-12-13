<?php
namespace app\classes;

class Mallmenus
{
    function return_menus()
	{
		$sql = "SELECT id, menu_name, language, visible, header_visible FROM menus WHERE visible = :vis AND language = :lng ORDER BY position"; // готовим запрос

        $res = Db::getInstance()->sql($sql, array("vis" => '1', "lng" => $_SESSION['language']));// выполняем запрос
        return $res; // возвращаем результат
    }
}
?>