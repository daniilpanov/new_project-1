<?php
namespace app\classes;

class Mallmenus
{
    protected function return_menus()
	{
        $res = Db::getInstance()->read("menus", "id, menu_name, language, visible, header_visible",
            false, array("visible" => '1', "language" => $_SESSION['language']), true, "position");
        return $res; // возвращаем результат
    }
}
?>