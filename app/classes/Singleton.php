<?php
namespace app\classes;

trait Singleton
{
    /**
     * В этом статическом свойстве
     * будет храниться объект этого класса
     * @var $instance self|null
     */
    private static $instance = null;

    // ЗАКРЫВАЕМ ВОЗМОЖНОСТЬ СОЗДАНИЯ И КЛОНИРОВАНИЯ ОБЪЕКТОВ ВНЕ КЛАССА
    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}

    /**
     * Статический метод для
     * получения объекта или его создания и получения,
     * если объекта ещё нет
     * @return self
     */
    public static function getInstance()
    {
        // Если объект ещё не создан,
        if (self::$instance === null)
        {
            // создаём его.
            self::$instance = new self();
        }
        // Возвращаем объект
        return self::$instance;
    }
}