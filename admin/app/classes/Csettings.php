<?php
namespace app\classes;

class Csettings extends Msettings
{		
	// переводим спецсимволы в html сущности
	function clean_data($str) 
	{
		if(get_magic_quotes_gpc() == 1) 
		{
			$str = htmlspecialchars($str) ;
		}
        
		return $str ;
	}
	
	// редактируем настройки
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
        $this->update_settings($aux_sql, $post);
    }
}
?>