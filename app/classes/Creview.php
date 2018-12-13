<?php
namespace app\classes;

class Creview extends Mreview
{
    // получаем количество отзывов на странице
    public function get_reviews_per_page($lng)
    {
        $res = $this->reviews_on_page($lng);
        $col = $res->fetch();
        return $col["reviews_on_page"];
    }

    // количество соседних ссылок от активной
    public function get_neighbours_links($lng)
    {
        $res = $this->neighbours_links($lng);
        $col = $res->fetch();
        return $col['reviews_neighbor_links'];
    }

    // посчитаем количество ссылок для отзывов
    public function pagination($lng, $id)
    {
        $reviews_per_page = $this->get_reviews_per_page($lng);

        $res = $this->reviews_count($id);
        $res = $res->fetch();

        $reviews = $res["COUNT(*)"];

        $col = ceil($reviews/$reviews_per_page);
        return $col;
    }

    // возвращаем отзывы для определенной страницы
    public function get_reviews_from_DB($lng,$id,$start)
    {
        $reviews_per_page = $this->get_reviews_per_page($lng);

        $start_from_page = ($start * $reviews_per_page) - $reviews_per_page;
        $res = $this->return_reviews($id, $start_from_page, $reviews_per_page); // запрос к БД
        while ($row = $res->fetch())
        {
            $review[$row['id']] = $row;
        }
        return $review;
    }

    // добавляем отзыв
    public function add_review($review)
    {
        if (!$review['phone'])
        {
            // проверяем не пришел ли отзыв с главной страницы
            if (!$review['page_id'])
            {
                $review['page_id'] = 1;
            }

            $result = $this->add_new_review($review);

            // если новый отзыв добавлен, то уведомим об этом администратора по электронной почте
            if($result)
            {
                $message = "<b>Текст отзыва:</b> <br>";
                $message .= $review['review'];
                $message .= "<br><a href = '{$_SERVER['HTTP_HOST']}/admin/views/reviews'>Одобрить отзыв</a><br>";

                $send_notification = Factory::getClassInst("SendMail", false, ["{$review['email']}",
                    "Новый отзыв от {$review['autor']} на сайте {$_SERVER['HTTP_HOST']}",
                    "{$message}"]);
                $send_notification->send("silent");

                echo $review["autor"].", мы получили ваш отзыв и вскоре добавим его.";

            }
            else
            {
                echo "Извините, но в процессе отправки отзыва произошла ошибка.";
            }
        }

    }
}