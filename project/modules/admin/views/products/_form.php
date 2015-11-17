<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use vova07\imperavi\Widget;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="products-form">


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'sdesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ldesc')->widget(Widget::classname(), [
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
            'imageUpload' => Url::to(['products/image-upload']),
            'imageManagerJson' => Url::to(['products/images-get']),
            'imageDeleteCallback' => new JsExpression('
                function(url, image){
                    $.ajax({
                        url: "'.Url::to(['products/imperavi-image-delete']).'",
                        type: "post",
                        data: {"url":url},
                    });}'),
            //'fileManagerJson' => Url::to(['/blog/files-get']),
            // 'fileUpload' => Url::to(['/blog/file-upload'])


        ]
    ]); ?>



    <?= $form->field($model, 'price')->textInput() ?>


    <?= $form->field($model, 'archive')->checkBox();?>

    <?php

    if ($model->isNewRecord) {
//Insert
        echo $form->field($model, 'images[]')->widget(FileInput::classname(), [
            'language' => 'ru',
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'previewFileType' => 'any',
                'showUpload' => false,
            ],
        ]);
    } else {
        //UPDATE
        echo $form->field($model, 'images[]')->widget(FileInput::classname(), [
            'language' => 'ru',
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'initialPreview' => array_map(function ($img) {
                        if (!empty($img->id)) {
                            return Html::img($img->getUrl(), ['class' => 'file-preview-image']);
                        } else {
                            return null;
                        }
                    },
                    $model->getImages()
                ),
                'initialPreviewConfig' => array_map(function ($img) use ($model) {
                        $config = [
                            'url' => Url::toRoute(['products/delete-image']),
                            'key' => $img->id,
                            'extra' => [
                                'idmodel' => $model->id,
                            ],
                        ];
                        return $config;
                    },
                    $model->getImages()
                ),
                'initialPreviewShowDelete' => true,
                'overwriteInitial' => false,
                'previewFileType' => 'any',
                'showUpload' => false,
                // 'uploadUrl' => Url::toRoute(['products/upload-image']),
                //   'uploadExtraData' => [
                //       'idmodel' => $model->id,
                //   ],
                'deleteURL' => Url::toRoute(['products/delete-image']),
                'deleteExtraData' => [
                    'idmodel' => $model->id,
                ],
            ],
        ]);
    }
    ?>

    <?= $form->field($model, 'paypal_button_code')->textarea(); ?>
    <?= HTML::a('Создать кнопку PayPal','https://www.paypal.com/buttons/select',['target'=>'_blank']);?>
    <br /><br />
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
