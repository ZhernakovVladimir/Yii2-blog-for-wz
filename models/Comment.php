<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $commentator_id
 * @property string $content
 * @property integer $article_id
 *
 * @property Articles $article
 * @property Commentator $commentator
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commentator_id', 'content', 'article_id'], 'required'],
            [['commentator_id', 'article_id'], 'integer'],
            [['content'], 'string'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['commentator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Commentator::className(), 'targetAttribute' => ['commentator_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'commentator_id' => 'Commentator ID',
            'content' => 'Content',
            'article_id' => 'Article ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentator()
    {
        return $this->hasOne(Commentator::className(), ['id' => 'commentator_id']);
    }
}
