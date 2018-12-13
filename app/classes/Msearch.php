<?php
namespace app\classes;

class Msearch
{
	function return_search($search)
	{
        $sql = "SELECT id, menu_name, content FROM pages WHERE menu_name LIKE :search OR content LIKE :search";
        $res = Db::getInstance()->sql($sql, array("search" => "%{$search}%"));// выполняем запрос
        return $res;
    }
}
?>