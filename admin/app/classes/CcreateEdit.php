<?php
namespace app\classes;

class CcreateEdit extends McreateEdit 
{
	// переводим спецсимволы в html сущности
	function clean_data($str) 
	{
		if(get_magic_quotes_gpc() == 1) 
		{
			$str = htmlspecialchars($str);
		}
        
		return $str ;
	}

	// создаем новую страницу
	function post_data($post)
	{ 
		// чистим
		foreach($post as $key => $value) 
		{
			$aux_post[$key] = $this->clean_data($value) ;
		}
		// устанавливаем позицию в меню
        $this->pos_inc($aux_post['position']);
		
        $aux_post['content']= nl2br($aux_post['content']);
		// отправляем информацию в базу
		$this->create($aux_post) ;
    }

    // возвращает список меню и добавляет надпись "-в конец списка-"
    function menu_return($last_pos = null,$lng)
	{
		// получаем список всех меню
        $res = $this->menu_pos($lng);
        while ($row = mysqli_fetch_assoc($res))
		{
            // заносим в новый массив
			$menu[$row['menu_name']] = $row['position'];
        }
		// добавляем в конец массива пункт "-в конец списка-"    
        if($last_pos)
		{
			$k = end($menu);
			$menu[$last_pos] = $k+1;
        }
        return $menu;
    }
    
    // возвращает список категорий
    function category_return($lng)
	{
		// получаем список всех категорий
        $res = $this->menu_pos($lng);
        
        // добавляем в начало массива пункт "нет" 
        $menu['-нет-'] = 0;
        
        while ($row = mysqli_fetch_assoc($res))
		{
            // заносим в новый массив
			$menu[$row['menu_name']] = $row['id'];
        } 
        
        return $menu;
    }
    
	// возвращает список всех страниц (id-массив с данными)
    function print_list($lng)
	{
        // получаем список всех страниц
		$list = $this->menu_pos($lng);
        while ($row = mysqli_fetch_assoc($list))
		{
            // помещаем результат в многомерный массив
			$m [$row['id']] = $row;
        }
        return $m;
    }

	// возвращает выбранную страницу для редактирования
    function print_pageedit($id)
	{ 
        $res = $this->retr_pageedit($id);
        $row = mysqli_fetch_assoc($res);
        return $row;
    }

    // редактируем страницу
    function update_data($post)
	{ 
        $aux_sql;
        $count = count($post)-1;
        $counter = 0;
        foreach ($post as $key => $val)
		{
            // чистим
			$val = $this->clean_data($val);
            
			if($key != 'id')
			{
                $counter++ ;
                if($counter != $count)
				{
                    $aux_sql .= $key.'=\''.$val.'\',';
                }
                else
				{
                    $aux_sql .= $key.'=\''.$val.'\'';
                }
            }
        }
		
        $this->pos_inc($post['position']);
		// отправляем информацию в базу
        $this->update_page($aux_sql, $post);
    }

    // удаляем страницу
    function del_page($id)
	{
        $res=$this->delete_page($id);
		return $res;
    }
	
	// возвращает список всех языков
    function print_languages_list($exclude)
	{
        $l=$this->language_list($exclude);
        
		while ($row = mysqli_fetch_assoc($l))
		{
            // заносим в новый массив
			$res[$row['language']] = $row['title'];
        }
        return $res;
    }

	// возвращает список всех меню
    function print_menu_list($exclude,$lng)
	{
        $l=$this->menu_list($exclude,$lng);
        
		while ($row = mysqli_fetch_assoc($l))
		{
            // заносим в новый массив
			$res[$row['id']] = $row['menu_name'];
        }
        return $res;
    }
               
}
?>