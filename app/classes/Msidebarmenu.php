<?php
namespace app\classes;

class Msidebarmenu
{
    protected function return_pages($menu_number)
	{
        $res = Db::getInstance()
            ->read("pages", "id, parent_id, menu_icon, icon_size, menu_name, active_link_in_sidebar",
                false, array("visible_in_sidebar" => "1", "menu_number" => $menu_number, "language" => $_SESSION['language']),
                true, "position");

        return $res; // возвращаем результат
    }
}
?>