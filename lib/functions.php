<?php

/**
 * Функция вывода преобразования числового значения рейтинга в графический (звёздочки)
 * @param $rating int
 * @return void
 */
function getRating($rating)
{
    switch ($rating)
    {
        case 1: echo "<i class=\"icon-star icon-large rating_red\"> </i>"; break;
        case 2: for($i=1;$i<=$rating;$i++){echo "<i class=\"icon-star icon-large rating_red\"> </i>";} break;
        case 3: for($i=1;$i<=$rating;$i++){echo "<i class=\"icon-star icon-large rating_yellow\"> </i>";} break;
        case 4: for($i=1;$i<=$rating;$i++){echo "<i class=\"icon-star icon-large rating_green\"> </i>";} break;
        case 5: for($i=1;$i<=$rating;$i++){echo "<i class=\"icon-star icon-large rating_green\"> </i>";} break;
    }
}