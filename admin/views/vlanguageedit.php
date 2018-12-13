<?php

$id = $_GET['languageedit'];

// получаем данные с базы о редактируемом языке
$language = $alllanguages->print_languageedit($id);
?>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $id;?>"/>
		
    <table class ="table_noborder">
    <tr>
        <td class="header_td">Редактирование языка "<?php echo $language['title'];?>"</td>            
    </tr>
    </table>
    
    <table class ="table_noborder">
    <tr>
		<td>статус: </td>
		<td><select name = "visible" class="select">			
			<option value = "1" <?php if($language['visible']== 1){echo "selected";}?>>включен</option>
			<option value = "0" <?php if($language['visible']== 0){echo "selected";}?>>отключен</option>	
			</select>
		</td>
	</tr>
	
	<tr>
		<td>основной язык сайта: </td>
			<td><select name = "default_lng" class="select">			
			<option value = "1" <?php if($language['default_lng']== 1){echo "selected";}?>>да</option>
			<option value = "0" <?php if($language['default_lng']== 0){echo "selected";}?>>нет</option>	
			</select>
		</td>
	</tr>	
	</table>
	<br />
	<input type="submit"  value="Сохранить">
</form>