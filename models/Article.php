<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $subscribtion
 * @property integer $published
 * @property string $published_at
 * @property integer $category_id
 * @property string $annoncement
 * @property string $preview
 *
 * @property ArticleTag[] $articleTags
 * @property Categtories $category
 */
class Article extends \yii\db\ActiveRecord
{

    protected $transaction;
    protected $tag_list=[];
    /**
     * @inheritdoc
     */


    public static function findCorrect()
    {
        return self::find()->where(['and',['<=','published_at',date('Y-m-d')],['=','published','1']]);
    }

    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'subscribtion', 'published', 'published_at', 'category_id', 'annoncement', 'preview'], 'required'],
            [['subscribtion', 'annoncement', 'preview'], 'string'],
            [['published'],'boolean'],
            [[ 'category_id'], 'integer'],
            [['published_at', 'taglist'], 'safe'],
            [['name'], 'string', 'max' => 1023],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'url' => 'Url',
            'subscribtion' => 'Описание',
            'published' => 'Опубликовано',
            'published_at' => 'Дата публикации',
            'category_id' => 'ID категории',
            'annoncement' => 'Анонс',
            'preview' => 'Превью',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('article_tag',['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    /**
     * @return boolean
     */
    public function hasIncorrectCategory()
    {
        return ($this->category->published == 0)//статья из непубликуемой категории
            or (strtotime($this->category->published_at) > time());//статья из непубликуемой категории по дате
    }

    /**
     * возвращает массив id тэгов связаных с данной статьёй
     * реализует get для свойства TagList
     * @return int[] tag::id => tag::id
     */
    public function getTagList()
    {
       return  ArrayHelper::map( $this->tags ,'id' , 'id' );
    }


    public function setTagList($list)
    {
        $this->tag_list = empty($list ) ? [] : $list;
    }

    public function beforeSave($insert)
    {
        $this->transaction = Yii::$app->db->beginTransaction();
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {

        if (!$insert)
        {
            ArticleTag::deleteAll('article_id = ' . $this->id);
        };

        foreach ($this->tag_list  as $tagID)
        {
            $at = new ArticleTag();
            $at->article_id = $this->id;
            $at->tag_id = $tagID;
            if(!($at->save())){
                $this->transaction->rollBack();
                return false;
            }
        }
        $this->transaction->commit();
        return parent::afterSave($insert, $changedAttributes);
    }
}
