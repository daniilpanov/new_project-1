<?php 
// узнаем язык страниц
foreach($list as $id => $menu_name){
	$lng [] = $menu_name[language];
}
?>

<form method="post">
<table class="table_page_list">
<tr class="table_header">
		<a href = "?page=rulist"><img title="русская версия сайта" alt="ru" src="../upload/images/ru.png" /></a>
		<a href = "?page=enlist"><img title="английская версия сайта" alt="en" src="../upload/images/en.png" /></a>
		<a href = "?page=<?php echo $lng [0];?>create" title="Добавить страницу" class="mysubmenu"><i class="icon-plus-sign icon-large mysubmenu"> </i></a>
    <td class="text_align_left">Название страницы</td>
    <td>Язык</td>
    <td>Создана</td>
    <td>Изменена</td>
    <td>Редактировать</td>
    <td>Удалить</td>
    <td><input title="отметить все" type="checkbox" name="maincheck" id="maincheck" class="checkbox"/></td>
</tr>
<?php
foreach($list as $id => $menu_name):
?>

    <tr>
        <td class="links"><i class="<?php echo $menu_name['menu_icon'];?> icon-1x"></i> <a title="редактировать" href="?edit=<?php echo $id;?>"> <?php echo $menu_name[menu_name];?></a></td>        
		<td>
		<?php 
			if ($menu_name[language]=="ru")
			{
				echo'<img title="русский" alt="ru" src="../upload/images/ru.png" border=0>';
			}
			else
			{
				echo'<img title="английский" alt="en" src="../upload/images/en.png" border=0>';
			}
				
		?>
		</td>
        <td><?php echo date("d.m.Y \в H:i:s",$menu_name[created]);?></td>
        <td>
            <?php
            if(!empty($menu_name[lastmod])){
                echo date("d.m.Y \в H:i:s",$menu_name[lastmod]);  
            }
            else{
                echo "нет изменений";
            }
            ?>
        </td>
		<td><a href="?edit=<?php echo $id;?>"><img title="редактировать" src="image/edit.png" /></a></td>
		<td><a href="?delete=<?php echo $id;?>" onclick='return confirm("Вы действительно хотите удалить страницу <?php echo $menu_name[menu_name];?>?")'><img title="удалить" src="image/delete.png" /></a></td>
		<td><input title="отметить" type="checkbox" name="delme[]"  value="<?php echo $id;?>" class="mc checkbox" /></td>
    </tr>
<?php endforeach;?>

<tr>
	<td></td><td></td><td></td><td></td><td></td><td></td>
	<td><input title="удалить отмеченные" type="image" name="submit" src="image/delete.png" onclick='return confirm("Вы действительно хотите удалить выделенные страницы?")' /></td>
</tr>

</table>
</form>