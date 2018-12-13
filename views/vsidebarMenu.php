<?php
use app\classes\Factory;

// подготавливаем обьекты
/** @var $menus \app\classes\Callmenus */
$menus = Factory::getClassInst("Callmenus"); // список доступных меню (таблица menus)
/** @var $pages \app\classes\CsidebarMenu */
$pages = Factory::getClassInst("CsidebarMenu"); // список доступных страниц для меню (таблица pages)

// получаем массив всех меню с БД $items[id] = array;
$menus_items = $menus->get_menus_from_DB();

echo '<ul id="demo1" class="nav">';

// выведедем каждое название меню по отдельности (одна итерация - одно меню)
foreach ($menus_items as $menu) {
    
	if($menu["header_visible"]== 1){
		echo "<h4>".$menu["menu_name"]."</h4>"; // выведем название меню
	}
	
	// ПОДГОТАВЛИВАЕМ МАССИВЫ СТРАНИЦ ДЛЯ ФОРМИРОВАНИЯ МЕНЮ

	// подготавливаем массив всех страниц для определённого меню $all_pages[id] = array(страница со всеми полями с этим id);
	$all_pages = $pages->get_pages_from_DB($menu["id"]);

	// подготавливаем массив дочерных страниц $children[$all_pages["id"]] = $all_pages["parent_id"]
    // например, $children[3] = 1;
	$children = $pages->prepare_children($all_pages);

	// выводим каждую страницу меню
	foreach ($all_pages as $item_page) {
		// если элемент не имеет дочерных элементов выводим его
		if(!$item_page["parent_id"]) {
			echo $pages->printItem($item_page, $all_pages, $children);
		}
	}
}

echo "</ul>";    
?>   