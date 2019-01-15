<?php
namespace app\classes;

class Mcontent
{
    protected function return_content($id = NULL)
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
            $id = 1;
			if($_SESSION['language'] == 'en')
			{
				$id = 2;
			}
        }

        $res = Db::getInstance()->read("pages", "*", false, array("id" => $id, "visible" => "1"), true, "", "", "1");
        return $res;
    }
}
?>