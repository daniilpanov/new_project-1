<?php
namespace app\classes;

class Msettings
{
    // возвращает название домена
	function return_domain()
	{
        $sql = "SELECT domainname  FROM constants WHERE id = 1";      
        $dom = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос;
		$res = mysqli_fetch_assoc($dom);
        return $res; // возвращаем результат
    }

	// возвращает настройки сайта для языковых констант
	function return_settings($lng){
		$sql = "SELECT site,footer  FROM constants WHERE language ='".$lng."'";
        $dom = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос;
        $res = mysqli_fetch_assoc($dom);
        return $res; // возвращаем результат
	}
	
	// возвращает все настройки сайта
	function return_all_settings($lng){
		$sql = "SELECT *  FROM constants WHERE language ='".$lng."'";
        $dom = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос;
        $res = mysqli_fetch_assoc($dom);
        return $res; // возвращаем результат
	}
	
	// редактируем все настройки сайта
    function update_settings($aux_sql, $post)
	{                       	
		$anotherlanguage = "SELECT language,title FROM languages WHERE language !='".$post['language']."'";
		$lng = \app\classes\Db::getInstance()->sql($anotherlanguage);// выполняем запрос;;
		$res = mysqli_fetch_assoc($lng);
		
		$sql = "UPDATE constants SET " .$aux_sql. " WHERE language ='".$post['language']."'";

        if (\app\classes\Db::getInstance()->sql($sql)  == 'true')
        {
            echo "<p class = 'center'><img src='image/ok.png' border=0>   Данные были успешно изменены!</p><p class = 'center'><a class = 'links' href=''>редактировать</a>&nbsp;|&nbsp;<a class = 'links' href='?page=".$res["language"]."settings'>список настроек для языка \"".$res["title"]."\"</a></p>";
        }
        else
		{
            echo "<p class = 'center'><img src='image/error.png' border=0>   Возникла ошибка при изменении данных!</p>";
        }
    }
	
}
?>