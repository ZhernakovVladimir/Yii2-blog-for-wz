<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subscribtion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'annoncement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'preview')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(\app\models\Category::find()->all(),'id','name'))?>

    <?= $form->field($model, 'taglist')->listBox(ArrayHelper::map(\app\models\Tag::find()->all(),'id','name'),['multiple' =>'multiple' ]) ?>

    <?= $form->field($model, 'published_at')->textInput(['type'=>'date','value' => $model->isNewRecord ? date('Y-m-d') : $model->published_at]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
