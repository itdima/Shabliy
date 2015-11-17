<?php
/* Шаблон для админки */
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\modules\admin\assets\AdminAsset;
use yii\helpers\Url;
use kartik\growl\Growl;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>


    <?php
    foreach (Yii::$app->session->getAllFlashes() as $message):;
        echo Growl::widget([
            'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
            'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
            'showSeparator' => true,
            'delay' => 1, //This delay is how long before the message shows
            'pluginOptions' => [
                'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                'placement' => [
                    'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                    'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                ]
            ]
        ]);

    endforeach;
    ?>



    <div class="container">
        <!-- Панель меню (navbar) -->
        <div class="navbar-wrapper">
            <div class="navbar navbar-default" role="navigation" id="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <?php
                        if (!Yii::$app->user->isGuest) {
                            ?>


                            <li class="">
                                <a href="<?= Url::toRoute(['products/index']); ?>">Управление товаром</a>
                            </li>

                            <li class="">
                                <a href="<?= Url::toRoute(['orders/index']); ?>">Заказы</a>
                            </li>

                            <li class="">
                                <a href="<?= Url::toRoute(['blog/index']); ?>">Дневник</a>
                            </li>

                            <li class="">
                                <a href="<?= Url::toRoute(['/main/index']); ?>">На сайт</a>
                            </li>

                            <li class="">
                                <a href="<?= Url::toRoute(['default/logout']); ?>">Выйти
                                    (<?= Yii::$app->user->identity->username; ?>)</a>
                            </li>

                        <?php } else { ?>
                            <li class="">
                                <a href="#">Войти</a>
                            </li>

                        <?php }; ?>


                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => [
                'label' => 'Главная',
                'url' => Yii::getAlias('@web/admin/')
            ]
        ]) ?>
        <?= $content ?>
    </div>



    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>