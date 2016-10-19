<?php

namespace app\components;
class View extends \yii\web\View
{
    public function render($view, $params = [], $context = null)
    {
        return str_ireplace('aaa', 'bbb', parent::render($view, $params, $context));
    }
}