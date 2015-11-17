<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 18.09.2015
 * Time: 10:27
 */
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-6">
        <?php
        $widget = \kotchuprik\fotorama\Widget::begin([
            'version' => '4.5.2',
            'options' => [
                'nav' => 'thumbs',
                'allowfullscreen' => 'true',
                'fit' => 'scaledown',
                'hash' => 'true',
                'keyboard' => 'true',
                //'navposition'=>'top',

            ],
            'htmlOptions' => [
                //   'class' => 'anotherCssClass',
                //  'data-ratio'=>"1.3333333333",
                'data-width' => "100%",
                'data-height' => "80%"
                //'data-ratio' => "800/600",

            ],
        ]);
        $images = $model->getImages();
        foreach ($images as $img) {
            echo '<img src="' . $img->getUrl('') . '">';
        }
        $widget->end();
        ?>

    </div>
    <div class="col-md-6 bear-info bodoni">
        <div class="text-center">
            <?= $model->ldesc ?>
        </div>
        <div>&nbsp;</div>
        <div class="text-center">
            <a id="toCart"
               href="<?= Url::to(['main/add-to-cart', 'id' => $model->id]); ?>"
               class="btn btn-default btn-block">
               <h4> Add to cart</h4>
            </a>
        </div>
        <div>&nbsp;</div>
        <div class="text-center">
            <?= $model->paypal_button_code; ?>
        </div>

    </div>
</div>