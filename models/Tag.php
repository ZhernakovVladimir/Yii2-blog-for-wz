<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property integer $url
 * @property integer $pulished
 *
 * @property Tags[] $Tags
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'pulished'], 'required'],
            [['published'], 'boolean'],
            [['url'], 'string', 'max' =>255 ],
            [['name'], 'string', 'max' => 1023],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя тэга',
            'url' => 'Url',
            'published' => 'Опубликовано',
        ];
    }

    public static function findCorrect()
    {
        return self::find()->where(['=','published',1]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('article_tag', ['tag_id' => 'id']);
    }
}
