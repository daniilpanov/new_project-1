<?php
namespace app\classes;

/**
 * @filename DB.php
 * набор компонентов для работы с БД (PDO Singleton)
 * @author Любомир Пона
 * @copyright 24.09.2013
 * @updated 29.09.2018
 */

class DbTest extends Config
{
    private static $instance = null; // объект для работы с БД
    /** @var $DBH \PDO */
    private static $DBH; // идентефикатор соединения
    private static $DSN = "mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME.";charset=".self::SQLCHARSET;
    // дополнительные параметры
    private static $OPT = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ];

    // закрываем возможность создания и дублирования объектов
    private function  __construct()
    {
        $this->open_connection();
    }
    private function __clone(){}
    private function __wakeup(){}

    // объект для работы с БД
    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }

        return self::$instance;

    }

    // соединяемся с БД
    private function open_connection()
    {
        try
        {
            self::$DBH = new \PDO(self::$DSN,self::DB_USER,self::DB_PASS,self::$OPT);
        }
        catch(\PDOException $e)
        {
            echo "Извините, но операция подключения к БД не может быть выполнена";
            // пишем все ошибки в файл с логами
            file_put_contents('DBlogs.txt',$e->getMessage()."\n",FILE_APPEND);
        }

    }


    // CRUD methods
    //
    public function create ($table, $data)
    {
        $sql = "INSERT INTO {$table} (";
        foreach ($data as $k=>$v)
        {
            $sql.= "{$k}, ";
        }

        $sql = substr($sql,0,-2);

        $sql .=") VALUES(";

        foreach ($data as $k=>$v)
        {
            $sql.= ":{$k}, ";
        }

        $sql = substr($sql,0,-2);

        $sql .=")";

        try
        {
            if($this->read($sql,$data))
            {
                echo "Данные были успешно добавлены";
            }

        }
        catch(\PDOException $e)
        {
            echo "Извините, но операция не может быть выполнена";
            // пишем все ошибки в файл с логами
            file_put_contents('DBlogs.txt',$e->getMessage()."\n",FILE_APPEND);
        }
    }
    //
    public function read($query, $values = NULL)
    {
        // если вместе с запросом был передан массив с данными
        if ($values!=NULL)
        {
            $STH =  self::$DBH->prepare($query);

            self::$DBH->setAttribute(\PDO::ATTR_EMULATE_PREPARES, $emulate);
            $STH->execute($values);
        }
        else
        {
            $STH = self::$DBH->query($query);
        }
        return $STH;
    }
    //
    public function update($table, $data, $where = NULL)
    {
        $sql = "UPDATE {$table} SET ";
        foreach ($data as $k=>$v)
        {
            $sql.= "{$k}=:{$k}, ";
        }

        $sql = substr($sql,0,-2);

        if($where)
        {
            foreach ($where as $col=>$value)
            {
                $sql.= " WHERE {$col}='{$value}' AND";
            }

            $sql = substr($sql,0,-3);
        }

        try
        {
            if($this->read($sql, $data))
            {
                echo "Данные были успешно обновлены";
            }

        }
        catch(\PDOException $e)
        {
            echo "Извините, но операция не может быть выполнена";
            // пишем все ошибки в файл с логами
            file_put_contents('DBlogs.txt',$e->getMessage()."\n",FILE_APPEND);
        }
    }
    //
    public function delete($table, $where)
    {
        $sql = "DELETE FROM {$table} WHERE id={$where}";

        try
        {
            if($this->read($sql))
            {
                echo "Данные были успешно удалены";
            }

        }
        catch(\PDOException $e)
        {
            echo "Извините, но операция не может быть выполнена";
            // пишем все ошибки в файл с логами
            file_put_contents('DBlogs.txt',$e->getMessage()."\n",FILE_APPEND);
        }

    }
}
?>

