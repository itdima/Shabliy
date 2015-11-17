<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article')->widget(Widget::classname(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 300,
            'pastePlainText' => true,
            'buttonSource' => true,
            'plugins' => [
                'fullscreen',
                'fontcolor',
                'fontfamily',
                'fontsize',
                'table'
            ],
            'imageUpload' => Url::to(['blog/image-upload']),
            'imageManagerJson' => Url::to(['blog/images-get']),
            'imageDeleteCallback' => new JsExpression('
                function(url, image){
                    $.ajax({
                        url: "'.Url::to(['blog/imperavi-image-delete']).'",
                        type: "post",
                        data: {"url":url},
                    });}'),
            //'fileManagerJson' => Url::to(['/blog/files-get']),
            // 'fileUpload' => Url::to(['/blog/file-upload'])


        ]
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
