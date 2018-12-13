<?php
namespace app\classes;

class Mmenu
{
    function return_menu()
	{
		$sql = "SELECT id, parent_id, menu_icon, icon_size, menu_name FROM pages
                  WHERE visible_in_main_menu = :visible_in_main_menu AND language = :language ORDER BY position"; // готовим запрос

        $res = Db::getInstance()->sql($sql, array("visible_in_main_menu" => "1", "language" => $_SESSION['language']));// выполняем запрос
        return $res; // возвращаем результат
    }
}
?>