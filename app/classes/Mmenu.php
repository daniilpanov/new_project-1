<?php
namespace app\classes;

class Mmenu
{
    protected function return_menu()
	{
        $res = Db::getInstance()->read("pages", "id, parent_id, menu_icon, icon_size, menu_name", false,
            array("visible_in_main_menu" => "1", "language" => $_SESSION['language']), true,
            "position");

        return $res; // возвращаем результат
    }
}
?>