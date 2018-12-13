<?php
namespace app\classes;

class Clanguages extends Mlanguages 
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
	
	// возвращает список всех языков
    function print_languages_list($exclude)
	{
        $l=$this->language_list($exclude);
        while ($row = mysqli_fetch_assoc($l))
		{
            // помещаем результат в многомерный массив
			$m [$row['id']] = $row;
        }
        return $m;;
    }
	
	// возвращает выбранный язык для редактирования
    function print_languageedit($id)
	{ 
        $res = $this->retr_languageedit($id);
        $row = mysqli_fetch_assoc($res);
        return $row;
    }
	
	// редактируем язык
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
		
		// отправляем информацию в базу
        $this->update_language($aux_sql, $post);
    }
}
?>