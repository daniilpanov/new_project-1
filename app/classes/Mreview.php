<?php
namespace app\classes;

class Mreview
{
    // получаем количество отзывов на странице
    protected function reviews_on_page($lng)
    {
        $res = Db::getInstance()->read("constants", "reviews_on_page", false, array("language" => $lng));
        return $res;
    }

    // получаем количество соседних ссылок от активной
    protected function neighbours_links($lng)
    {
        $res = Db::getInstance()->read("constants", "reviews_neighbor_links", false, array('language' => $lng));
        return $res;
    }

    // пагинация
    protected function reviews_count($id)
    {
        $res = Db::getInstance()->read("reviews", "*", true, array("page_id" => $id, "state" => "good"));// выполняем запрос
        return $res;
    }

    // вернуть все отзывы
    protected function return_reviews($id, $start_from_page, $lim)
    {
        $res = Db::getInstance()->read(
            "reviews", "id, name, review, autor, created, rating", false,
            array("visible" => "1", "page_id" => $id, "state" => "good"),
            true, "id", "DESC", "{$start_from_page}, {$lim}"
        );
        return $res; // возвращаем результат
    }

    // добавить новый отзыв
    protected function add_new_review($review)
    {
        unset($review['phone']);
        unset($review['review_submit']);
        // Добавляем доп. элементы в массив
        $review['visible'] = "1"; // видимость отзыва
        $review['state'] = "new"; // статус отзыва

        $res = Db::getInstance()->sql("reviews", $review, true); // выполняем запрос
        return $res; // возвращаем результат

    }

}