<?php
namespace app\classes;

class Msidebarmenu
{
    function return_pages($menu_number)
	{	
		$sql = /** @lang MySQL */
            "SELECT id, parent_id, menu_icon, icon_size, menu_name, active_link_in_sidebar FROM pages 
                WHERE visible_in_sidebar = :visible_in_sidebar AND menu_number = :menu_number AND language = :language ORDER BY position";
        $res = Db::getInstance()
            ->sql($sql, array("visible_in_sidebar" => "1", "menu_number" => $menu_number, "language" => $_SESSION['language']));// выполняем запрос
        return $res; // возвращаем результат
    }
}
?>