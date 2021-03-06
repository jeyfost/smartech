<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.01.2018
 * Time: 18:34
 */

function dateToString($date) {
    $year = substr($date, 0, 4);
    $month = substr($date, 5, 2);
    $day = substr($date, 8, 2);

    switch((int)$month) {
        case 1:
            $month = "января";
            break;
        case 2:
            $month = "февраля";
            break;
        case 3:
            $month = "марта";
            break;
        case 4:
            $month = "апреля";
            break;
        case 5:
            $month = "мая";
            break;
        case 6:
            $month = "июня";
            break;
        case 7:
            $month = "июля";
            break;
        case 8:
            $month = "августа";
            break;
        case 9:
            $month = "сентября";
            break;
        case 10:
            $month = "октября";
            break;
        case 11:
            $month = "ноября";
            break;
        case 12:
            $month = "декабря";
            break;
        default: break;
    }

    $date = (int)$day." ".$month." ".$year." г.";

    return $date;
}

function dateTimeToString($date) {
    $year = substr($date, 0, 4);
    $month = substr($date, 5, 2);
    $day = substr($date, 8, 2);
    $hour = substr($date, 11, 2);
    $minute = substr($date, 14, 2);
    $secund = substr($date, 17, 2);

    switch((int)$month) {
        case 1:
            $month = "января";
            break;
        case 2:
            $month = "февраля";
            break;
        case 3:
            $month = "марта";
            break;
        case 4:
            $month = "апреля";
            break;
        case 5:
            $month = "мая";
            break;
        case 6:
            $month = "июня";
            break;
        case 7:
            $month = "июля";
            break;
        case 8:
            $month = "августа";
            break;
        case 9:
            $month = "сентября";
            break;
        case 10:
            $month = "октября";
            break;
        case 11:
            $month = "ноября";
            break;
        case 12:
            $month = "декабря";
            break;
        default: break;
    }

    $date = (int)$day." ".$month." ".$year." г. в ".$hour.":".$minute.":".$secund;

    return $date;
}

function calculatePrice($price) {
    $price = $price." руб.";

    return $price;
}

function real_ip() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
        return $_SERVER['HTTP_X_REAL_IP'];
    }

    return $_SERVER['REMOTE_ADDR'];
}