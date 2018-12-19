<?php
namespace app\classes;

class Mcontent
{
    function return_content($id = NULL)
	{
        // если выбран id
		if($id)
		{
            settype($id, 'integer');
        }

		// если попали в корень домена
        if(!$id)
		{
            // проверяем язык по умолчанию
            $id=1;
			if($_SESSION['language']=='en')
			{
				$id=2;
			}
        }
        $sql = /** @lang MySQL */
            "SELECT * FROM pages WHERE id = :id AND visible = :visible LIMIT 1";

        $res = Db::getInstance()->sql($sql, array("id" => $id, "visible" => "1"));// выполняем запрос
        return $res;
    }
}
?>