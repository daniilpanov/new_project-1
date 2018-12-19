<?php
$editpage = new \app\classes\CcreateEdit();
$id = $_GET['edit'];

// получаем данные с базы о редактируемой странице
$page = $editpage->print_pageedit($id);

// получаем список всех языков
$all_languages = $editpage->print_languages_list("");
// получаем список всех языков кроме выбранного
$exclude_language = $editpage->print_languages_list($page['language']);

// получаем список всех меню
$all_menus = $editpage->print_menu_list("",$page['language']);
// получаем список всех меню кроме выбранного
$exclude_menu = $editpage->print_menu_list($page['menu_number'],$page['language']);


?>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $id;?>"/>
		
    <table class ="table_noborder">
    <tr>
        <td class="header_td">Редактирование страницы "<?php echo $page['menu_name'];?>"</td>
        <td class="header_td"><a href="?delete=<?php echo $id;?>" onclick='return confirm("Вы действительно хотите удалить страницу <?php echo $page['menu_name'];?>?")'><img class="right" title="удалить страницу" src="image/delete.png" /></a></td>             
    </tr>
    </table>
    
    <table class ="table_noborder">
    <tr>
		<td>язык страницы: </td>
		<td><select name = "language" class="select">
			
			<option value = "<?php echo $page['language'];?>" "selected">
			<?php 
			foreach ($all_languages as $key=> $value)
			{
				if($key == $page['language'])
				{
					echo $value;
				}
			}
			?>
			</option>
						
			<?php
			foreach ($exclude_language as $key => $value)
			{
			?>
			<option value = "<?php echo $key; ?>"><?php echo $value;?></option>
			<?php
            }
            ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>описание (description): </td>
		<td><input type="text" name = "description" size = "105" value = "<?php echo $page['description'];?>"/></td>
	</tr>
	<tr>
		<td>ключевые слова (keywords): </td> 
		<td><input type="text" name = "keywords" size = "105" value = "<?php echo $page['keywords'];?>" /></td>
	</tr>
	<tr>
		<td>заголовок страницы (title): </td>
		<td><input type="text" name = "title" size = "105" value = "<?php echo $page['title'];?>" /></td>
	</tr>
	<tr>
		<td>иконка: <i class="<?php echo $page['menu_icon'];?> icon-1x"> </i> (<a href="http://fontawesome.veliovgroup.com/design.html" title="список названий" target="_blank">список иконок</a>)</td>
		<td><input type="text" name = "menu_icon" size = "105" value = "<?php echo $page['menu_icon'];?>" /></td>
	</tr>
	<tr>
		<td>размер иконки: </td>
		<td><select name = "icon_size" class="select">
                        <option value = "<?php echo $page['icon_size'];?>" "selected"><?php echo $page['icon_size']; ?></option>
						<option value = "icon-1x">icon-1x</option>
						<option value = "icon-2x">icon-2x</option>
						<option value = "icon-3x">icon-3x</option>
						<option value = "icon-4x">icon-4x</option>						
						<option value = "icon-large">icon-large</option>

            </select>
		</td>
	</tr>
	<tr>
		<td>название страницы в меню: </td>
		<td><input type="text" name = "menu_name" size = "105" value = "<?php echo $page['menu_name'];?>" /></td>
	</tr>
	<tr>
        <td>позиция в меню: </td>
		<td><select name = "position" class="select">
                        <?php $menu = $vcreateedit->menu_return('-в конец списка-',$page['language']);
                                                                        
                        foreach ($menu as $menu_name => $position)
						{
                        ?>
                        <option value = "<?php echo $position; ?>"<?php if($menu_name == $page['menu_name']){echo "selected";}?>><?php echo $menu_name; ?></option>
                        <?php
                        }
                        ?>
            </select>
		</td>
	</tr>
	<tr>
		<td>родительский пункт меню: </td>
		<td><select name = "parent_id" class="select">
                        <?php $parent_category = $vcreateedit->category_return($page['language']);
                                                                        
                        foreach ($parent_category as $menu_name => $id)
						{
                        ?>
                        <option value = "<?php echo $id; ?>"<?php if($id == $page['parent_id']){echo "selected";}?>><?php echo $menu_name; ?></option>
                        <?php
                        }
                        ?>
            </select>
		</td>
	</tr>
	<tr>					
		<td>отображать в главном меню:	</td>
		<td><select name = "visible_in_main_menu" class="select">
			<option value = "1" <?php if($page['visible_in_main_menu']== 1){echo "selected";}?>>отображать</option>
			<option value = "0" <?php if($page['visible_in_main_menu']== 0){echo "selected";}?>>скрыть</option>
			</select>
		</td>
	</tr>
	<tr>					
		<td>отображать в боковом меню:	</td>
		<td><select name = "visible_in_sidebar" class="select">
			<option value = "1" <?php if($page['visible_in_sidebar']== 1){echo "selected";}?>>отображать</option>
			<option value = "0" <?php if($page['visible_in_sidebar']== 0){echo "selected";}?>>скрыть</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>выберите боковое меню: </td>
		<td><select name = "menu_number" class="select">			
			<option value = "<?php echo $page['menu_number'];?>" "selected">
			<?php 
			foreach ($all_menus as $key=> $value)
			{
				if($key == $page['menu_number'])
				{
					echo $value;
				}				
			}
			if(!$page['menu_number']){
				echo"-нет-";
			}
			?>
			</option>
									
			<?php
			foreach ($exclude_menu as $key => $value)
			{
			?>
			<option value = "<?php echo $key; ?>"><?php echo $value;?></option>
			<?php
			}
			if($page['menu_number'])
			{			
	        ?>
			<option value = "0">-нет-</option>
			<?php
			}
			?>
			</select>
		</td>
	</tr>
	<tr>					
		<td>ссылка в боковом меню:	</td>
		<td><select name = "active_link_in_sidebar" class="select">
			<option value = "1" <?php if($page['active_link_in_sidebar']== 1){echo "selected";}?>>да</option>
			<option value = "0" <?php if($page['active_link_in_sidebar']== 0){echo "selected";}?>>нет</option>
			</select>
		</td>
	</tr>
	<tr>					
		<td>публикация страницы:	</td>
		<td><select name = "visible" class="select">
			<option value = "1" <?php if($page['visible']== 1){echo "selected";}?>>опубликовать</option>
			<option value = "0" <?php if($page['visible']== 0){echo "selected";}?>>скрыть</option>
			</select>
		</td>
	</tr>
    <tr>
        <td>отображать отзывы:	</td>
        <td><select name = "reviews_visible" class="select">
             <option value = "1" <?php if($page['reviews_visible']== 1){echo "selected";}?>>отображать</option>
             <option value = "0" <?php if($page['reviews_visible']== 0){echo "selected";}?>>скрыть</option>
             </select>
        </td>
    </tr>
    <tr>
        <td>возможность добавлять отзывы:	</td>
        <td><select name = "reviews_add" class="select">
            <option value = "1" <?php if($page['reviews_add']== 1){echo "selected";}?>>да</option>
            <option value = "0" <?php if($page['reviews_add']== 0){echo "selected";}?>>нет</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>форма обратной связи: </td>
        <td><select name = "contacts_visible" class="select">
                <option value = "1" <?php if($page['contacts_visible']== 1){echo "selected";}?>>отображать</option>
                <option value = "0" <?php if($page['contacts_visible']== 0){echo "selected";}?>>скрыть</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>форма обратной связи (файлы): </td>
        <td><select name = "contacts_files_attach" class="select">
                <option value = "1" <?php if($page['contacts_files_attach']== 1){echo "selected";}?>>прикреплять</option>
                <option value = "0" <?php if($page['contacts_files_attach']== 0){echo "selected";}?>>не прикреплять</option>
            </select>
        </td>
    </tr>
    <tr>
		<td>текст страницы:<td>
	</tr>
	</table>
	<textarea name = "content" id="editor1" cols="54" rows="3"><?php  $cont['content'] = str_replace("<br />","", $page['content']);echo$cont['content'];?></textarea><br />
	<input type="submit"  value="Сохранить">
</form>
<script type="text/javascript">
var ckeditor = CKEDITOR.replace('editor1');
</script>