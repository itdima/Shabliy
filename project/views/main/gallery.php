<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 22.09.2015
 * Time: 13:16
 */
?>

<div class="row">
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
            'data-height' => "80%",
            //'data-ratio' => "800/600",

        ],
    ]);
    foreach ($models as $model) {
        $images = $model->getImages();
        foreach ($images as $img) {
            echo '<a href="' . $img->getUrl() . '"></a>';
        }
    }
    $widget->end();
    ?>
</div>