<?php
namespace app\classes;

class Csearch extends Msearch  // класс поиска по сайту
{
	// проверка запроса
	public function check_query($check)
	{
		$search = trim($check); // удалим пробелы
		$search = htmlspecialchars($search); // преобразуем HTML-сущности в соответствующие символы 	


			if (strlen($search) < 2)
			{
				die('<p>Слишком короткий поисковый запрос.</p>');
			} 
			else if (strlen($search) > 64) 
			{
				die('<p>Слишком длинный поисковый запрос.</p>');
			} 
			else
			{
				return $search;
			}
		
	}
	
	public function print_search($query)
	{
        // проверяем запрос
		$checked_search = $this->check_query($query);
		
		// получаем список всех строк с БД соответствующих запросу
		$rowslist = $this->return_search($checked_search);
        while ($row = $rowslist->fetch())
		{
            // помещаем каждую строку в многомерный массив
			$s[$row['id']] = $row;
        }
        return $s;
    }
}
?>