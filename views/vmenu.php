<?php
use app\classes\Factory;

/**
 * подготавливаем обьекты
 * @var $main_menu \app\classes\Cmenu
 */
$main_menu = Factory::getClassInst("Cmenu"); // список элементов меню

// получаем массив всего меню с БД $items[id] = array;
$items = $main_menu->get_menu_from_DB();

// подготавливаем массив дочерных элементов $childrens[$item["id"]] = $item["parent_id"]
$childrens = $main_menu->prepare_childrens($items); 

echo '<ul class="nav navbar-nav">';

// выводим каждый элемент
foreach ($items as $item) {
    // если элемент не имеет дочерных элементов выводим его
    if (!$item["parent_id"]) echo $main_menu->printItem($item, $items, $childrens);
}

echo "</ul>";
?>
<!--форма поиска-->
<form class="navbar-form navbar-right" role="search" method="POST">
        <div class="input-group search">
			<input name="search" type="text" class="form-control" placeholder="<?=SEARCH?>">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default"><i class="icon-search icon-small"> </i></button>
			</span>
		</div>
</form>
<?php
// если язык включен в настройках, выводим флаг
$al = $site_ini->return_active_language();

foreach($al as $value){

	if($value)
	{
	?>
		<a class="language" href = "?lang=<?=LANGUAGE?>&amp;id=<?=LANGUAGEID?>&amp;review=1"><img title="<?=LANGUAGEALT?>"alt="ru" src="upload/images/<?=LANGUAGEIMG?>" /></a>
	<?php
	}
}
?>