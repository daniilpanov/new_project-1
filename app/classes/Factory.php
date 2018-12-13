<?php
namespace app\classes;


class Factory
{

    /**
     * @var $instances array|object[]
     */
    private static $instances = array();

    /**
     * @param $class
     * @param bool $singleton
     * @param bool|array $construct_args
     * @return mixed|object
     */
    public static function getClassInst($class, $singleton = true, $construct_args = false)
    {
        // Пространство имён с именем класса
        $class_full_name = "\\app\\classes\\".$class;

        // Пробуем создать объект
        try
        {
            // Если класс не существует, то
            if (!class_exists($class_full_name))
            {
                // генерируем исключение
                throw new \Exception("Invalid class name");
            }
            else
            {
                if ($singleton)
                {
                    // По принципу Singleton с доп. функциями
                    // Если нам надо создать указанный объект, то
                    if (!isset(self::$instances[$class]))
                    {
                        // присваеваем элементу статического массива объект нужного класса
                        self::$instances[$class] = new $class_full_name();
                    }

                    // И в любом случае, мы возвращаем элемент массива с указанным ключом
                    return self::$instances[$class];
                }
                else
                {
                    // Если конструктор класса принимает аргументы
                    if ($construct_args)
                    {
                        $obj = new \ReflectionClass($class_full_name);
                        return $obj->newInstanceArgs($construct_args);
                    }
                    else
                    {
                        return new $class_full_name();
                    }
                }
            }
        }
        // Пытаемся поймать исключение
        catch (\Exception $exception)
        {
            $error = date("j.m.Y \a\\t G:i:s") . "\n".
                $exception->getMessage() . "\n\n";
            file_put_contents('logs/Factory_log.txt', $error,FILE_APPEND);
        }
    }
}