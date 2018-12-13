<?php
$ll = new \app\classes\Clanguages();
$list = $ll->print_languages_list("");
?>
<table class="table_page_list">
<tr class="table_header">
    <td class="text_align_left">Язык</td>
	<td>Флаг</td>
    <td>Статус</td>
    <td>Основной язык сайта</td>
    <td>Редактировать</td>
</tr>
<?php
foreach($list as $key => $value):
?>

    <tr>
        <td class="links"><a title="редактировать" href="?languageedit=<?php echo $value[id];?>"> <?php echo $value[title];?></a></td>        
		<td>
		<?php 
			if ($value[language]=="ru")
			{
				echo'<img title="русский" alt="ru" src="../upload/images/ru.png" border=0>';
			}
			else
			{
				echo'<img title="английский" alt="en" src="../upload/images/en.png" border=0>';
			}
				
		?>
		</td>
        <td>
		<?php 
			if ($value[visible])
			{
				echo'включен';
			}
			else
			{
				echo'отключен';
			}
				
		?>
		</td>   
		<td>
		<?php 
			if ($value[default_lng])
			{
				echo'да';
			}
			else
			{
				echo'нет';
			}
		?>
		</td>  
		<td><a href="?languageedit=<?php echo $value[id];?>"><img title="редактировать" src="image/edit.png" /></a></td>		
    </tr>
<?php endforeach;?>

</table>