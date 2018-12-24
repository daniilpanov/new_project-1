<?php
namespace app\classes;


class Uninstall
{
    public $progress = 0;
    private $lng;
    const CONFIG = "app/classes/Config.php";

    use Singleton;

    private function __construct()
    {
        $this->lng = ($_SESSION['language'] == null) ? "ru" : $_SESSION['language'];
    }

    public function getTitle()
    {
        $title = "";

        switch ($this->progress)
        {
            case 0:
                switch ($this->lng)
                {
                    case "ru":
                        $title = "Введите пароль для подтверждения удаления";
                        break;
                    case "en":
                        $title = "";
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

    public function checkPassword(string $password)
    {
        $login = new Login();

        $password = $login->clean_password($password);

        $right_password = mysqli_fetch_assoc($login->return_authorisation())['password'];

        $res = ($password == $right_password);

        return $res;
    }

    public function getErrorMessage()
    {
        return "
        <div class='alert alert-danger alert-dismissable fade show' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            <h4 class='alert-heading'>Ошибка!</h4>
            <p>Вы неправильно ввели пароль. Попробуйте ещё раз</p>
        </div>
        ";
    }

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
                $res = false;
            }
        }

        $res = ($res !== false) ? $this->deleteFiles() : false;

        return $res;
    }

    public function deleteFiles()
    {
        $res = true;

        if (!unlink(self::CONFIG)
            || !unlink("../".self::CONFIG)
            || !unlink("../.htaccess")
        )
        {
            $res = false;
        }

        return $res;
    }
}