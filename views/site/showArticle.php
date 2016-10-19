<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title =$article->category->name . '/' . $article->name ;
    $this->params['breadcrumbs'][] =[
        'label' => $article->category->name,
        'url' => '/' . $article->category->url,
    ];
    $this->params['breadcrumbs'][] =[
        'label' => $article->name,
        //'url' => $article->url,
    ];

?>

    <ul>
        <li><?= $article->name?></li>
        <li><?= $article->subscribtion ?></li>
    </ul>
    <hr>

<?php if(count($article->comments) == 0 ): ?>

    <h3>Станьте первым прокомментировавшим эту статью</h3>

<?php else:?>
    <?php foreach ($article->comments as $comment):?>

        <b><?= $comment->commentator->name?></b><br>
        <?= $comment->content ?><br><br>

    <?php endforeach;?>
<?php endif;?>

    <hr>

<?php
    $error = \Yii::$app->session->getFlash('commentFormError');
if (!empty($error)):?>
    <div class="alert alert-danger" role="alert"><?= $error?></div>
<?php endif;?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Оставить комментарий' , ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>