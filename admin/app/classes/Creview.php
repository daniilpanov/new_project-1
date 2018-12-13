<?php
namespace app\classes;

class Creview extends Mreview
{
    // возвращаем отзывы для определенной страницы
    public function get_reviews_from_DB($page){

        $res = $this->return_reviews($page); // запрос к БД
        while ($row = mysqli_fetch_assoc($res))
        {
            $review[$row['id']] = $row;
        }
        return $review;
    }

    public function add_review($review){

        //проверяем не пришел ли отзыв с главной страницы
        if (!$review['page_id']) {
            $review['page_id'] = 1;
        }

        $result = $this->add_new_review($review);
        if($result){
            echo $review["autor"].", мы получили ваш отзыв и вскоре добавим его.";
        }
        else{
            echo "Извините, но в процессе отправки отзыва произошла ошибка.";
        }
    }
}