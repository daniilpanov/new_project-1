<?php
namespace app\classes;


class Uninstall
{
    public $title_number = 0; // это свойство проверяется в методе getTitle
    private $lng; // берётся с сессии
    private $error = ""; // сообщение об ошибке
    const CONFIG = "app/classes/Config.php";

    use Singleton;

    private function __construct()
    {
        $this->lng = ($_SESSION['language'] == null) ? "ru" : $_SESSION['language'];
    }

    // Получение HTML-title
    public function getTitle()
    {
        $title = "";

        switch ($this->title_number)
        {
            case 0:
                switch ($this->lng)
                {
                    case "ru":
                        $title = "Введите пароль для подтверждения удаления";
                        break;
                    case "en":
                        $title = "Type password for confirm delete";
                        break;
                }
                break;
            case 1:
                switch ($this->lng)
                {
                    case "ru":
                        $title = "Удаление...";
                        break;
                    case "en":
                        $title = "Deleting...";
                        break;
                }
                break;
            case 2:
                switch ($this->lng)
                {
                    case "ru":
                        $title = "Вся информация с Вашего сайта удалена!";
                        break;
                    case "en":
                        $title = "All information from your site was deleted!";
                        break;
                }
                break;
        }

        return $title;
    }

    public function getForm()
    {
        // Возвращаем HTML-код (форма с полем для пароля)
        return "
        <form method='post'>
            <label>
                Введите пароль: &emsp;
                <input type='password' name='password' placeholder='Пароль'>
                <button type='submit' class='btn btn-danger'>Продолжить&emsp;&rArr;</button>
            </label>
        </form>
        ";
    }

    // Проверка пароля
    public function checkPassword(string $password)
    {
        $login = new Login(); // новый объект класса Login
        // Шифруем пароль
        $password = $login->clean_password($password);
        // Получаем с БД всю информацию о пользователе
        $user = mysqli_fetch_assoc($login->return_authorisation());
        $right_password = $user['password']; // записываем пароль

        // Если пароли не совпадают, то меняем сообщение об ошибке
        if (!$res = ($password == $right_password))
        {
            $this->error = "Вы неправильно ввели пароль. Попробуйте ещё раз";
        }

        return $res;
    }

    public function getErrorMessage()
    {
        return ($this->error !== "") ? "
        <div class='alert alert-danger alert-dismissable fade show' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            <h4 class='alert-heading'>Ошибка!</h4>
            <p>{$this->error}</p>
        </div>
        " : "";
    }

    // Удаление таблиц с БД и конф. файлов
    public function delete()
    {
        $res = true;

        $sql = /** @lang MySQL */ "SHOW TABLES FROM new_project";

        $tables = Db::getInstance()->sql($sql);

        $sql = "DROP TABLE ";

        while ($table = mysqli_fetch_assoc($tables))
        {
            if (!Db::getInstance()->sql($sql.$table['Tables_in_new_project']))
            {
                $this->error .= "<br />Таблица {$table['Tables_in_new_project']} не удалена!";
                $res = false;
            }
        }

        // Если таблицы в БД удалены, то удаляем конфигурационные файлы
        if ($res)
        {
            if (!unlink(self::CONFIG)
                || !unlink("../".self::CONFIG)
                || !unlink("../.htaccess")
                || !unlink("../logs.txt")
            )
            {
                $this->error .= "<br />Файлы не удалены!";
                $res = false;
            }
        }

        return $res;
    }
}