<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 07.09.2015
 * Time: 13:26
 */
/* @var $models app\models\Products */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


$this->title = 'Catalog';
$this->params['breadcrumbs'][] = $this->title;
if (!$models) {
    ?>
    <div class="row">
        <p>Sorry, search result is empty!</p>
    </div>
<?php

}
if ($models) {
    $i = 0;
    $cnt = count($models);
    foreach ($models as $model) {
        $i++;
        if ($i % 4 == 0 || $i == 1) {
            echo '<div class="row">';
        }
        ?>
        <div class="col-md-4 bodoni">
            <div class="thumbnail shadow">
                <?php

            //  echo '<img style="width:75%" src="' .  $model->getImage()->getUrl('') . '">';
                $widget = \kotchuprik\fotorama\Widget::begin([
                    'version' => '4.5.2',
                    'options' => [
                        // 'nav' => 'thumbs',
                        'allowfullscreen' => 'true',
                        'fit' => 'scaledown',
                        'hash' => 'true',
                        'keyboard' => 'true',
                        //'navposition'=>'top',
                    ],
                    'htmlOptions' => [
                        'data-width' => "100%",
                        'data-height' => "50%"
                    ],
                ]);
                $images = $model->getImages();
                foreach ($images as $img) {
                    echo '<a href="' . $img->getUrl('') . '"></a>';
                }
                $widget->end();

                ?>

                <div class="caption text-center">
                    <h4>
                        <a href="<?= Url::toRoute(['main/bear-info', 'id' => $model->id]); ?>"
                           title="info"><?= $model->sdesc; ?></a>
                    </h4>
                    <h4>
                        <span>  <?= $model->price; ?> $</span>
                    </h4>
                </div>

                <div class="caption">
                    <a href="<?= Url::toRoute(['main/bear-info', 'id' => $model->id]); ?>"
                       class="btn btn-default btn-sm btn-block">
                        <h4>Make order...</h4>
                    </a>
                </div>
            </div>
        </div>
        <?php
        if ($i % 3 == 0 || $cnt == $i) {
            echo '</div>';
        }
    }
}

echo \yii\widgets\LinkPager::widget(['pagination' => $pagination]);
?>