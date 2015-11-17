<?php

namespace app\modules\admin;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();
       // Yii::$app->getUrlManager()->setBaseUrl(Yii::$app->getUrlManager()->getBaseUrl().'/admin/');
        //Yii::$app->setHomeUrl('/');
        Yii::$app->user->loginUrl = Yii::$app->urlManager->createUrl(['admin/default/login']);
        Yii::$app->errorHandler->errorAction = 'admin/default/error';


        // custom initialization code goes here
    }
}
