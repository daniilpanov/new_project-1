<?php
$editpage = new \app\classes\CcreateEdit();

// получаем список всех языков
$all_languages = $editpage->print_languages_list('');
// получаем список всех меню
$all_menus = $editpage->print_menu_list("","en");
?>
<form method="post">
	<select name = "language"  class="select" hidden>
		<option value = "en">english</option>
	</select>
    <table class ="table_noborder">
	<tr>
		<td colspan="2" class="header_td">Добавление новой страницы</td>
	<tr>
		<td>описание (description): </td>
		<td><input type="text" name = "description" size = "105" /></td>
	</tr>
	<tr>
		<td>ключевые слова (keywords): </td> 
		<td><input type="text" name = "keywords" size = "105" /></td>
	</tr>
	<tr>	
		<td>заголовок страницы (title): </td>
		<td><input type="text" name = "title" size = "105" /></td>
	</tr>
	<tr>
		<td>иконка: (<a href="http://fontawesome.veliovgroup.com/design.html" title="список названий" target="_blank">список иконок</a>)</td>
		<td><input type="text" name = "menu_icon" size = "105" value = "<?php echo $page['menu_icon'];?>" /></td>
	</tr>
	<tr>
		<td>размер иконки: </td>
		<td><select name = "icon_size" class="select">
                        <option value = "icon-large" "selected">icon-large</option>
						<option value = "icon-1x">icon-1x</option>
						<option value = "icon-2x">icon-2x</option>
						<option value = "icon-3x">icon-3x</option>
						<option value = "icon-4x">icon-4x</option>
            </select>
		</td>
	</tr>
	<tr>
		<td>название страницы в меню: </td>
		<td><input type="text" name = "menu_name"  size = "105"/></td>
	</tr>
	<tr>
        <td>позиция в меню: </td>
		<td><select name = "position"  class="select">
                        <?php $menu = $vcreateedit->menu_return('-в конец списка-','en');
                        $max = count($menu);
                        $counter = 0;

                        foreach ($menu as $menu_name => $position)
						{
                            $counter++;
                                if($counter != $max)
								{?>
                                     <option value = "<?php echo $position; ?>"><?php echo $menu_name; ?></option>                                       
                                <?php
                                }
								else 
								{?>
                                     <option value = "<?php echo $position; ?>" selected><?php echo $menu_name; ?></option>
                        <?php   }
						} 
						?>
            </select>
		</td>
	</tr>
    <tr>
		<td>родительский пункт меню: </td>
		<td><select name = "parent_id"  class="select">
                        <?php $parent_category = $vcreateedit->category_return('en');
                                                                        
                        foreach ($parent_category as $menu_name => $id)
						{
                        ?>
                        <option value = "<?php echo $id; ?>"><?php echo $menu_name; ?></option>
                        <?php
                        }
                        ?>
            </select>
        </td>
	</tr>
	<tr>					
		<td>отображать в главном меню:	</td>
		<td><select name = "visible_in_main_menu"  class="select">
			<option value = "0">скрыть</option>
			<option value = "1">отображать</option>
			</select>
		</td>
	</tr>
	<tr>					
		<td>отображать в боковом меню:	</td>
		<td><select name = "visible_in_sidebar"  class="select">
			<option value = "1">отображать</option>
			<option value = "0">скрыть</option>
			</select>
		</td>
	</tr>
	<tr>
	<td>выберите боковое меню: </td>
		<td><select name = "menu_number" class="select">
			<option value = "0" "selected">-нет-</option>
			<?php 
			foreach ($all_menus as $key=>$value)
			{
					
					echo "<option value = \"".$key."\">".$value."</option>\n\t\t\t";
			}
			?>			
			</select>
		</td>
	</tr>
	<tr>					
		<td>ссылка в боковом меню:	</td>
		<td><select name = "active_link_in_sidebar"  class="select">
			<option value = "1">да</option>
			<option value = "0">нет</option>
			</select>
		</td>
	</tr>
	<tr>					
		<td>публикация страницы:	</td>
		<td><select name = "visible" class="select">
			<option value = "1">опубликовать</option>
  			<option value = "0">скрыть</option>
			</select>
		</td>
	</tr>
    <tr>
        <td>отображать отзывы:	</td>
        <td><select name = "reviews_visible" class="select">
            <option value = "0">скрыть</option>
            <option value = "1">отображать</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>возможность добавлять отзывы:	</td>
        <td><select name = "reviews_add" class="select">
            <option value = "0">нет</option>
            <option value = "1">да</option>
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
	<textarea name="content" id="editor1" cols="54" rows="3"></textarea><br />
	<input type="submit" name="create" value="Добавить страницу">
</form>
<script type="text/javascript">
var ckeditor = CKEDITOR.replace('editor1');
</script>