
<form method="post">
    <table class="table_page_list">
        <tr class="table_header">
            <td class="text_align_left">Название отзыва</td>
            <td class="text_align_left">
                <select name = "page_id" class="select">
                    <option value = "Главная" "selected">
                    Главная
                    </option>
                </select>
            </td>
            <td class="text_align_left">Дата <input type="text" name="created"></td>
            <td>Редактировать</td>
            <td>
                <select name = "state"  class="select">
                    <option value = "0">Опубликован</option>
                    <option value = "1">На модерации</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><a href="?reviewedit="><img title="редактировать" src="image/edit.png" /></a></td>
        </tr>
    </table>
</form>