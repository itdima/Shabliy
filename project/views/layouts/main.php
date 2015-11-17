<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Mail;

AppAsset::register($this);
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
    echo \kartik\growl\Growl::widget([
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

<div class="wrap container">
    <div id="logo" class="row">
        <div class="visible-sm visible-md visible-lg">
            <a href="<?= Yii::getAlias('@web') ?>">
                <img src="<?= Yii::getAlias('@web') . '/img/Logo.png' ?>" alt="Familial Values Logo"
                     class="img-rounded">
            </a>
        </div>

        <div class="visible-xs">
            <a href="<?= Yii::getAlias('@web') ?>">
                <img src="<?= Yii::getAlias('@web') . '/img/Logo_sm.png' ?>" alt="Familial Values Logo"
                     class="img-rounded">
            </a>
        </div>

    </div>

    <!-- Панель меню (navbar) -->
    <div class="navbar-wrapper bodoni">
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
                <ul class="nav nav-pills nav-justified">

                    <li class="">
                        <a href="<?= Url::toRoute(['main/catalog']); ?>">Available Bears</a>
                    </li>
                    <li class="">
                        <a href="<?= Url::toRoute(['main/gallery']); ?>">Gallery</a>
                    </li>
                    <li class="">
                        <a href="<?= Url::toRoute(['main/blog']); ?>">Blog</a>
                    </li>

                    <li class="">
                        <a href="<?= Url::toRoute(['main/about']); ?>">About us</a>
                    </li>

                    <li>
                        <a id="cartlink" href="<?= Url::to(['main/cart']); ?>">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                            <span id="num"><?= \Yii::$app->cart->getCount(); ?></span>
                            <span class="visible-lg-inline"> items </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => [
                'label' => 'Home',
                'url' => Yii::getAlias('@web')
            ]
        ]) ?>
        <?= $content ?>
    </div>

</div>
<div class="container">
    <footer class="footer bodoni">
        <div class="row">
            <div class="col-sm-4">
                <p>&copy; Familial Values <?= date('Y') ?></p>
            </div>
            <div class="col-sm-4 text-center">
                <div id="socseti" class="btn-group btn-group-sm">

                    <div class="btn btn-default" rel="tooltip" title="Facebook" data-toggle="tooltip"
                         data-placement="top">
                        <a class="footer-a" href="https://www.facebook.com/kristina.shabliy" target="_blank"><i
                                class="fa fa-facebook"></i></a>
                    </div>

                    <div title="VK" rel="tooltip" data-toggle="tooltip" data-placement="top"
                         class="btn btn-default">
                        <a class="footer-a" href="https://vk.com/kristincos" target="_blank"><i
                                class="fa fa-vk"></i></a>
                    </div>

                    <div title="Instagram" rel="tooltip" data-toggle="tooltip" data-placement="top"
                         class="btn btn-default">
                        <a class="footer-a" href="https://instagram.com/kristina_shabliy/" target="_blank"><i
                                class="fa fa-instagram"></i></a>
                    </div>

                    <div title="E-Mail" rel="tooltip" data-placement="top" data-toggle="modal" data-target="#email"
                         class="btn btn-default">
                        <a class="footer-a" href="#"><i class="fa fa-envelope-o"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <p class="pull-right">
                    <? //= Yii::powered() ?>
                    Powered by <a href="mailto:itdima@mail.ru" rel="external">ITDima</a>
                </p>
            </div>
        </div>

    </footer>
</div>

<div id="email" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">E-Mail</h4>
            </div>
            <div class="modal-body">
                <?php
                $mail = new Mail();
                $form = ActiveForm::begin(['action' => ['main/email'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($mail, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($mail, 'body')->textArea(['maxlength' => true]) ?>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-default']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
