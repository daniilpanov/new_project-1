<?php
namespace app\classes;

class McreateEdit
{
	// возвращает список всех страниц 
	function retr ()
	{ 
        $sql = /** @lang MySQL */ "SELECT id, position, menu_name, language FROM pages ORDER BY position ASC";
        $res = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
        return $res; // возвращаем результат
    }
	
	// возвращает список всех языков
	function language_list($exclude)
	{ 
        $sql = /** @lang MySQL */ "SELECT * FROM languages WHERE language <> '{$exclude}'";
        $res = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
        return $res; // возвращаем результат
    }
	
	// возвращает список всех меню
	function menu_list($exclude,$lng)
	{ 
        $sql = /** @lang MySQL */ "SELECT * FROM menus WHERE id <> '{$exclude}' AND language = '{$lng}'";
        $res = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
        return $res; // возвращаем результат
    }
	
	// создает новую страницу
	function create($post) 
	{ 
		$dt = time(); // текущая метка времени
        
        $sql = "insert into
				pages(description,parent_id,keywords,language,title,menu_icon,icon_size,menu_number,menu_name,position,visible,visible_in_main_menu,visible_in_sidebar,active_link_in_sidebar,reviews_visible,reviews_add,content,created)
				VALUES('{$post['description']}','{$post['parent_id']}','{$post['keywords']}','{$post['language']}','{$post['title']}','{$post['menu_icon']}','{$post['icon_size']}','{$post['menu_number']}',
				'{$post['menu_name']}',{$post['position']},'{$post['visible']}','{$post['visible_in_main_menu']}','{$post['visible_in_sidebar']}','{$post['active_link_in_sidebar']}','{$post['reviews_visible']}','{$post['reviews_add']}','{$post['content']}','{$dt}')" ;

                        
                        if ($res = \app\classes\Db::getInstance()->sql($sql) == 'true')
                        {
                        echo "<p class = 'center'><img src='image/ok.png' border=0>   Новая страница была успешно добавлена!</p><p class = 'center'><a class = 'links' href=''>создать еще</a>&nbsp;|&nbsp;<a class = 'links' href='?page=".$post['language']."list'>список страниц</a></p>";
                        }
                        else
						{
                        echo "<p class = 'center'><img src='image/error.png' border=0>   Возникла ошибка при добавлении новой страницы!</p>";
                        }
                       	return true ;
	}
                
    // возвращает выбранную страницу для редактирования
    function retr_pageedit($id)
	{ 
        $sql = /** @lang MySQL */ 'SELECT * FROM pages WHERE id = '.$id.'';
        $res = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
        return $res; // возвращаем результат
    }

    // редактируем страницу
    function update_page($aux_sql, $post)
	{
        $dt = time(); // текущая метка времени
        
        $sql = 'UPDATE pages SET ' .$aux_sql. ',lastmod='.$dt.'  WHERE id ='.$post['id'].'';
        if ($res = \app\classes\Db::getInstance()->sql($sql) == 'true')
        {
            echo "<p class = 'center'><img src='image/ok.png' border=0>   Данные были успешно изменены!</p><p class = 'center'><a class = 'links' href=''>редактировать</a>&nbsp;|&nbsp;<a class = 'links' href='?page=".$post['language']."list'>список страниц</a></p>";
        }
        else
		{
            echo "<p class = 'center'><img src='image/error.png' border=0>   Возникла ошибка при изменении данных!</p>";
        }
    }

    // удаляем выбранную страницу
    function delete_page($id)
	{
        $sql = 'DELETE  FROM pages WHERE id = '.$id.'';
        if (!$res = \app\classes\Db::getInstance()->sql($sql))
		{
			echo "<p class = 'center'><img src='image/error.png' border=0>   Возникла ошибка при удалении страницы!</p>";	
		}        
		else
		{
			return $res; // возвращаем результат
		}
		
    }
	
	// возвращает список всех страниц со всей информацией по каждой
	function menu_pos($lng)
	{ 
        $sql = "SELECT * FROM pages WHERE language = '{$lng}' ORDER BY position ASC";
        $res = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
        return $res; // возвращаем результат
    }
    
    // позиция в меню
	function pos_inc($pos)
	{
        $sql = "UPDATE pages SET position = position+1 WHERE position >= {$pos}";
        \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
    }
}
?>