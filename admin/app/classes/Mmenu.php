<?php
namespace app\classes;

class Mmenu
{
	// возвращает список всех меню со всей информацией по каждому
	function menu_pos($lng)
	{ 
        $sql = "SELECT * FROM menus WHERE language = '{$lng}' ORDER BY position ASC";
        $res = \app\classes\Db::getInstance()->read($sql);// выполняем запрос
        return $res; // возвращаем результат
    }
	
	// создает новое меню
	function create($post) 
	{ 			

        /*$sql = "insert into
				menus(menu_name,position,language,created,visible,header_visible)
				VALUES('{$post['menu_name']}','{$post['position']}','{$post['language']}','{$post['visible']}','{$post['header_visible']}')" ;*/

        if (\app\classes\Db::getInstance()->create("menus", $post, true))
        {
            echo "<p class = 'center'><img src='image/ok.png' border=0>   Новое меню успешно добавлено!</p><p class = 'center'><a class = 'links' href=''>создать еще</a>&nbsp;|&nbsp;<a class = 'links' href='?page=".$post['language']."menulist'>список меню</a></p>";
        }
        else
        {
            echo "<p class = 'center'><img src='image/error.png' border=0>   Возникла ошибка при добавлении нового меню!</p>";
        }
        return true;
	}
	
	// возвращает выбранное меню для редактирования
    function retr_menuedit($id)
	{ 
        $sql = 'SELECT * FROM menus WHERE id = '.$id.'';
        $res = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
        return $res; // возвращаем результат
    }
	
	// редактируем меню
    function update_menu($aux_sql, $post)
	{
        $dt = time(); // текущая метка времени
        
        $sql = 'UPDATE menus SET ' .$aux_sql. ',lastmod='.$dt.'  WHERE id ='.$post['id'].'';
        if ($res = \app\classes\Db::getInstance()->sql($sql) == 'true')
        {
            echo "<p class = 'center'><img src='image/ok.png' border=0>   Данные были успешно изменены!</p><p class = 'center'><a class = 'links' href=''>редактировать</a>&nbsp;|&nbsp;<a class = 'links' href='?page=".$post['language']."menulist'>список меню</a></p>";
        }
        else
		{
            echo "<p class = 'center'><img src='image/error.png' border=0>   Возникла ошибка при изменении данных!</p>";
        }
    }
	
	// удаляем выбранное меню
    function delete_menu($id)
	{
        $sql = 'DELETE  FROM menus WHERE id = '.$id.'';
        if (!$res = \app\classes\Db::getInstance()->sql($sql))
		{
			echo "<p class = 'center'><img src='image/error.png' border=0>   Возникла ошибка при удалении меню!</p>";	
		}        
		else
		{
			return $res; // возвращаем результат
		}
		
    }
	
	// позиция
	function pos_inc($pos)
	{
        //$sql = "UPDATE menus SET position = position+1 WHERE position >= {$pos}";
        \app\classes\Db::getInstance()->update("menus", array("position" => "position+1"), array("position" => "{$pos}"), ">=", false);// выполняем запрос
    }

}
?>