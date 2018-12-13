<?php
namespace app\classes;

class Mreview
{
    // получаем количество отзывов на странице
    protected function reviews_on_page($lng)
    {
        $sql = /** @lang MySQL */
            "SELECT reviews_on_page FROM constants WHERE language = :language";
        $res = Db::getInstance()->sql($sql, array("language" => $lng));// выполняем запрос
        return $res;
    }

    // получаем количество соседних ссылок от активной
    protected function neighbours_links($lng)
    {
        $sql = /** @lang MySQL */
            "SELECT reviews_neighbor_links FROM constants WHERE language = :lng";
        $res = Db::getInstance()->sql($sql, array('lng' => $lng));
        return $res;
    }

    // пагинация
    protected function reviews_count($id)
    {
        $sql = /** @lang MySQL */
            "SELECT COUNT(*) FROM reviews WHERE page_id = :page_id AND state = :state"; // готовим запрос

        $res = Db::getInstance()->sql($sql, array("page_id" => $id, "state" => "good"));// выполняем запрос
        return $res;
    }

    // вернуть все отзывы
    protected function return_reviews($id, $start_from_page, $lim)
    {
        $sql = /** @lang MySQL */
            "SELECT id, name, review, autor, created, rating 
                FROM reviews WHERE visible = :visible AND page_id = :page_id AND state = :state
                ORDER BY id DESC LIMIT $start_from_page, $lim"; // готовим запрос

        $res = Db::getInstance()
            ->sql(
                $sql, array("visible" => "1", "page_id" => $id, "state" => "good")
            );// выполняем запрос
        return $res; // возвращаем результат
    }

    // добавить новый отзыв
    protected function add_new_review($review)
    {
        unset($review['phone']);
        unset($review['review_submit']);
        // Добавляем доп. элементы в массив
        $review['created'] = time(); // текущая метка времени
        $review['visible'] = "1"; // видимость отзыва
        $review['state'] = "new"; // статус отзыва

        // Переменная с SQL-запросом
        $templates = ") VALUES(";

        $sql = "INSERT INTO reviews (";

        foreach ($review as $k=>$v)
        {
            $sql.= "{$k}, ";
            $templates.= ":{$k}, ";
        }

        $sql = substr($sql,0,-2);

        $templates = substr($templates,0,-2);

        $sql = $sql.$templates.")";

        $res = Db::getInstance()->sql($sql, $review); // выполняем запрос
        return $res; // возвращаем результат

    }

}