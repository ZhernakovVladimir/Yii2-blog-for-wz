<?php
namespace app\components;

use app\models\Category;
use app\models\Tag;
use yii\base\Widget;

class UserMenuWidget extends Widget
{
    public function init()
    {

    }

    public function run()
    {
        $categorylist= $this->getCategoryList();
        $taglist = $this->getTagList();
        return $this->render('usermenu',compact('taglist','categorylist'));
    }

    protected function getCategoryList()
    {
        $categorylist = \Yii::$app->cache->get('categorylistForMainMenu');
        if ($categorylist){return $categorylist;}

        $categories= Category::findCorrect()->all();
        $categorylist = $this->render('categorylist', compact('categories'));
        \Yii::$app->cache->set('categorylistForMainMenu', $categorylist, 3600);

        return $categorylist;
    }

    protected function getTagList()
    {
        $taglist = \Yii::$app->cache->get('taglistForMainMenu');
        if ($taglist){return $taglist;}

        $tags= Tag::findCorrect()->all();
        $taglist = $this->render('taglist', compact('tags'));
        \Yii::$app->cache->set('taglistForMainMenu', $taglist, 3600);

        return $taglist;
    }
}