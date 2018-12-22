<?php
/**
 * Created by PhpStorm.
 * User: NUC2
 * Date: 22.12.2018
 * Time: 16:31
 */

namespace app\classes;


class newDb
{

    // CRUD methods
    // получение
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

            $sql .= 'created_at, ';
        }

        $sql = substr($sql,0,-2);

        $sql .=") VALUES (";

        foreach ($data as $k=>$v)
        {
            $sql.= ":{$k}, ";
        }

        if ($timestamps)
        {

            $sql .= ':created_at, ';
            $data['created_at'] = time();
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
    // обновление
    public function update($table, $data, $where = NULL, $timestamps=false)
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
    // удаление
    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id={$id}";

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