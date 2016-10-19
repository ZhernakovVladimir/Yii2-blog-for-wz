<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categtories".
 *
 * @property string $name
 * @property string $url
 * @property string $subscribtion
 * @property string $published
 * @property string $published_at
 * @property integer $id
 *
 * @property Articles[] $articles
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'subscribtion', 'published', 'published_at'], 'required'],
            [['subscribtion'], 'string'],
            [['published'],'boolean'],
            [['published_at'], 'safe'],
            [['name'], 'string', 'max' => 1023],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'url' => 'Url',
            'subscribtion' => 'Описание',
            'published' => 'Опубликовано',
            'published_at' => 'Дата публикации',
            'id' => 'ID',
        ];
    }

    public static function findCorrect()
    {
        return self::find()->where(['and',['<=','published_at',date('Y-m-d')],['=','published',1]]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }
}
