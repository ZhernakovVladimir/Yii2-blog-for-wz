<?php

namespace app\models;


use yii\base\Exception;
use yii\base\Model;

class CommentForm extends Model
{
    public $name;
    public $email;
    public $text;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'text'], 'required'],
            ['email', 'email'],
            ['text','safe']
           // ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => ' Имя',
            'text' => 'Текст сообщения',
        ];
    }

    /**
     * @return bool  : success
     */
    public function saveComment($article_id)
    {

        try{
            $commentator = Commentator::findOrCreate($this->name, $this->email);
        }catch(Exception $e){
            \Yii::$app->session->setFlash('commentFormError',$e->getMessage());
            return false;
        };

        $comment = new Comment();
        $comment->content = $this->text;
        $comment->article_id = $article_id;
        $comment->commentator_id = $commentator->id;

        return $comment->save();
    }
}