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

            //echo $query; // для отладки
            $error = date("j.m.Y \a\\t G:i:s") . "\n".
                $e->getMessage() . "\n\n";

            // пишем все ошибки в файл с логами
            file_put_contents('logs.txt', $error, FILE_APPEND);
        }

        return $STH;
    }

    // получение
    public function read($table, $items = "*", $count = FALSE, $where = NULL, $templates = TRUE, $limit = NULL, $order_by = NULL, $how = "ASC")
    {
        // Генерируем начальный запрос (SELECT $items FROM $table)
        // (если надо посчитать элеементы, то "SELECT <u>COUNT($items)</u> FROM $table)
        $query = ($count) ? "SELECT COUNT({$items}) FROM {$table}" : "SELECT {$items} FROM {$table}";
        $tmp = array(); // объявляем массив для именованных шаблонов

        // Если указано, откуда надо брать данные, то
        if ($where !== NULL)
        {
            $query .= " WHERE "; // добавляем к запросу "WHERE"
            // и если нужно применять именованные шаблоны,
            if ($templates)
            {
                // перебираем $where как ключ и значение
                foreach ($where as $index => $item)
                {
                    // добавляем в запрос именованные шаблоны
                    $query .= "{$index} = :{$index} AND ";
                    $tmp[$index] = $item; // и записываем эти именованные шаблоны в массив
                }
                // <u>обрезаем последнее <code>"AND "</code></u>
                $query = substr($query, 0, -4);

                // Пример такого запроса: <i>"SELECT * FROM test WHERE id = :id AND info = :info "</i>
                // (массив с им. шаблонами) <pre>Array('id' => '1', 'info' => 'Тест', )</pre>
            }
            // иначе
            else
            {
                // просто перебираем массив $where как ключ и значение
                foreach ($where as $index => $item)
                {
                    // и вставляем в запрос
                    $query .= "{$index} = {$item} AND ";
                }
                // <u>и также обрезаем последнее <code>"AND "</code></u>
                $query = substr($query, 0, -4);

                // Пример такого запроса: <i>"SELECT * FROM test WHERE id = '1' AND info = 'Тест'
            }
        }

        //
        $query .= ($order_by !== NULL) ? " ORDER BY {$order_by} {$how}" : "";
        //
        $query .= ($limit !== NULL) ? " LIMIT {$limit}" : "";

        // Выполняем запрос
        $STH = $this->sql($query, $tmp);
        // и возвращаем результат
        return $STH;
    }
}
?>