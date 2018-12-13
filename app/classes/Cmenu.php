<?php
namespace app\classes;

class Cmenu extends Mmenu 
{      
    // возвращаем меню с БД
    public function get_menu_from_DB(){	
        
        $res = $this->return_menu(); // запрос к БД
		while ($row = $res->fetch())
		{
			$mname[$row['id']] = $row; 
		}
        return $mname;
    }
    
    // подготавливаем массив дочерных элементов
    public function prepare_childrens($items){
        
        foreach ($items as $item) {
            if ($item["parent_id"]) $childrens[$item["id"]] = $item["parent_id"];
        }
        return $childrens;
    }
    
    //Выводим пункт меню
    public function printItem($item, $items, $childrens){
    
		echo '<li class="dropdown">';
		echo "<a class=\"dropdown-toggle\" data-target=\"#\" href=\"".DOMAINNAME."/?id=$item[id]&review=1\"><i class=\"$item[menu_icon] $item[icon_size]\"> </i> $item[menu_name]</a>";
		
		// Выводились ли дочерние элементы?
		$ul = false;
		
		//Бесконечный цикл, в котором мы ищем все дочерние элементы
		while (true) {
			
		  // Ищем в массиве $childrens елементы которые принадлежат родителю
		  $key = array_search($item["id"], $childrens); // если нет - вылетаем с цикла while
		  
		  // Если дочерних элементов не найдено 
		  if (!$key) {
			// Если выводились дочерние элементы, то закрываем список
			if ($ul) echo "</ul>"; 
			break; // Выходим из цикла
		  }
		  
		  // Удаляем найденный элемент (чтобы он не выводился ещё раз)
		  unset($childrens[$key]); 
		  
		  if (!$ul) {
			echo '<ul class="dropdown-menu parent">'; // Начинаем внутренний список, если дочерних элементов ещё не было
			$ul = true; // Устанавливаем флаг
		  }
		  
		  // Рекурсивно выводим все дочерние элементы
		  echo self::printItem($items[$key], $items, $childrens); 
		}
		echo "</li>";
  }  
    
}
?>