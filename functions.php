<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.10.2016
 * Time: 20:01
 */

function dd($var)
{
    ob_end_clean();
    echo '<pre>';
    var_dump($var);
    die;
}