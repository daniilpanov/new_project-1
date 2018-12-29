<?php
namespace app\classes;

/**
 * @filename DB.php
 * набор компонентов для работы с БД (PDO Singleton)
 * @author Любомир Пона
 * @copyright 24.09.2013
 * @updated 29.09.2018
 */

class Db extends Config
{
    /**
     * @var $DBH \PDO
     * идентефикатор соединения,
     * @var $DSN string
     * для подключения к БД.
    ---------------------------
     * @var $OPT array
     * дополнительные параметры.
     */
    private static
        $DBH = NULL,
        $DSN = "mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME.";charset=".self::SQLCHARSET,

        $OPT = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ];

    // Используем паттерн Singleton
    use Singleton;

    // При создании объекта вызываем метод open_connection
    private function __construct()
    {
        $this->open_connection();
    }

    // соединяемся с БД
    private function open_connection()
    {
        try
        {
            self::$DBH = new \PDO(self::$DSN, self::DB_USER, self::DB_PASS, self::$OPT);
            $STH = self::$DBH->query("SET NAMES utf8");
        }
        catch(\PDOException $e)
        {
            echo "Извините, но операция подключения к БД не может быть выполнена";
            $error = date("j.m.Y \a\\t G:i:s") . "\n".
                $e->getMessage() . "\n\n";
            file_put_contents('logs.txt', $error,FILE_APPEND);
        }
    }

    // реализация запроса к БД
    public function sql(string $query, array $params = NULL, bool $emulate = TRUE) : \PDOStatement
    {
        echo $query;
        try
        {
            // если вместе с запросом был передан массив с данными
            if ($params !== NULL)
            {
                $STH = self::$DBH->prepare($query);

                self::$DBH->setAttribute(\PDO::ATTR_EMULATE_PREPARES, $emulate);
                $STH->execute($params);
            }
            else
            {
                $STH = self::$DBH->query($query);
            }
        }
        catch(\PDOException $e)
        {
            switch ($_SESSION['language'])
            {
                case 'ru':
                    echo "<b>Извините</b>, но операция <i>не может быть выполнена</i>";
                    break;
                case 'en':
                    echo "<b>Sorry</b>, but the operation <i>can't be done</i>";
                    break;
            }

            $error = date("j.m.Y \a\\t G:i:s") . "\n".
                $e->getMessage() . "\n\n";

            // пишем все ошибки в файл с логами
            file_put_contents('logs.txt', $error, FILE_APPEND);
        }

        return $STH;
    }


    // CRUD methods
    // получение
    public function read($query, $values = NULL)
    {
        // если вместе с запросом был передан массив с данными
        $STH = $this->sql($query, $values);
        return $STH;
    }
    // добавление
    public function create ($table, $data, $timestamps=false)
    {
        $sql = "INSERT INTO {$table} (";
        foreach ($data as $k=>$v)
        {
            $sql.= "{$k}, ";
        }

        if ($timestamps)
        {

            $sql .= 'created, ';
        }

        $sql = substr($sql,0,-2);

        $sql .=") VALUES (";

        foreach ($data as $k=>$v)
        {
            $sql.= ":{$k}, ";
        }

        if ($timestamps)
        {

            $sql .= ':created, ';
            $data['created'] = time();
        }

        $sql = substr($sql,0,-2);

        $sql .=")";

        if($this->sql($sql, $data))
        {
            echo "Данные были успешно добавлены";
        }
    }
    // обновление
    public function update($table, $data, $where = NULL, $operator = "=", $emulate = true, $timestamps = false)
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
                $sql.= " WHERE {$col}{$operator}'{$value}' AND ";
            }

            $sql = substr($sql,0,-4);
        }

        if($this->sql($sql, $data, $emulate))
        {
            echo "Данные были успешно обновлены";
        }
    }
    // удаление
    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id={$id}";

        if($this->sql($sql))
        {
            echo "Данные были успешно удалены";
        }
    }

}