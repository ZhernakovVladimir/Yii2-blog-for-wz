<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "commentators".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 *
 * @property Comment[] $comments
 */
class Commentator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commentators';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['email'],'email'],
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
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */




    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['commentator_id' => 'id']);
    }

    /**
     * находит  или создёт нового комментатора по имени(name). Если имя задействовано
     * с другим email выбрасывает исключение
     *
     * @param $name
     * @param $email
     * @return Commentator
     * @throws Exception
     */
    public static function findOrCreate($name ,$email)
    {
        $item = self::find()->where(['=', 'name', $name])->one();
        if($item == null){
            $item = new Commentator();
            $item->name = $name;
            $item->email = $email;
            $item->save();
            return $item;
        }
        if ($item->email <> $email){throw new Exception('Имя пользователя уже задействовано');}
        return $item;
    }
}
