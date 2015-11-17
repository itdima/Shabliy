<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\blog */

$this->title = 'Обновить статью: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Дневник', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="blog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
