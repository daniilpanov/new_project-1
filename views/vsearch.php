<?php
use app\classes\Factory;


echo "<p><h2>".SEARCH1."</h2></p>";
$search_word = $_POST['search'];

// создаем новый обьект
$vsearch_list = Factory::getClassInst("Csearch");
// делаем запрос 
$list = $vsearch_list->print_search($search_word);
// считаем количество найденных совпадений
$rows = count($list);

echo SEARCH2."<b>".$search_word."</b>".SEARCH3." ".$rows." ".SEARCH4;
echo "<br /><br />";

foreach($list as $id => $search_row)
{
	// формируем ссылки
	// $pos = strpos($search_row['content'], $search_word);
	// $description = substr($search_row['content'], $pos, 2);
	echo "<a href=\"?id={$search_row['id']}&review=1\">{$search_row['menu_name']}</a><br />";
	
		
}

?>