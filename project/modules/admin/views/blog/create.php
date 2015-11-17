<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\blog */

$this->title = 'Добавить статью';
$this->params['breadcrumbs'][] = ['label' => 'Дневник', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
