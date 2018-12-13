<?php
namespace app\classes;

class Cmenu extends Mmenu
{
	// переводим спецсимволы в html сущности
	function clean_data($str) 
	{
		if(get_magic_quotes_gpc() == 1) 
		{
			$str = str_replace('\"', "&quot;", $str) ;
			$str = str_replace("\'", "&#039;", $str) ;
			$str = str_replace("<", "&lt;", $str) ;
			$str = str_replace(">", "&gt;", $str) ;
		}
        
		return $str ;
	}
	
	// создаем новое меню
	function post_data($post)
	{ 
		// чистим
		foreach($post as $key => $value) 
		{
			$aux_post[$key] = $this->clean_data($value) ;
		}
		// устанавливаем позицию в меню
        $this->pos_inc($aux_post['position']);

		// отправляем информацию в базу
		$this->create($aux_post) ;
    }
	
	// возвращает список всех меню (id-массив с данными)
    function print_list($lng)
	{
        // получаем список всех меню
		$list = $this->menu_pos($lng);
        while ($row = mysqli_fetch_assoc($list))
		{
            // помещаем результат в многомерный массив
			$m [$row['id']] = $row;
        }
        return $m;
    }

	// возвращает выбранное меню для редактирования
    function print_menuedit($id)
	{ 
        $res = $this->retr_menuedit($id);
        $row = mysqli_fetch_assoc($res);
        return $row;
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
	
	// редактируем меню
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
        $this->update_menu($aux_sql, $post);
    }
	
	// удаляем меню
    function del_menu($id)
	{
        $res=$this->delete_menu($id);
		return $res;
    }
	
}
?>