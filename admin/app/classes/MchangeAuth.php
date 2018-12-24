<?php
namespace app\classes;

class MchangeAuth extends Login
{
	// обновляем логин/пароль для входа в систему администрирования
	function change_authentification($login, $pass1)
	{
        $sql = /** @lang MySQL */"UPDATE users SET login = '$login', password = '$pass1' WHERE id = '1'";
        
		if ($res = \app\classes\Db::getInstance()->sql($sql) == 'true')
        {
            echo "<p class='center'><img src='image/ok.png' border=0>
                Ваши данные для входа в систему управления сайтом были успешно изменены!</p>
                <p class='center'><a href='?page=changeauth'>изменить еще раз</a>&nbsp;|&nbsp;
                <a class='links' href='exit.php'>выход из системы администрирования</a></p>";
        }
        else
		{
            echo "<p class = 'center'><img src='image/error.png' border=0>Возникла ошибка при изминении данных!</p>
                <p class = 'center'><a href='?page=changeauth'>попытаться еще раз</a></p>";
        }
		return true;
        
    }
}
?>