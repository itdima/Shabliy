<?php

namespace app\modules\admin\controllers;

use rico\yii2images\models\Image;
use Yii;
use app\models\Products;
use app\modules\admin\models\ProductsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;



/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends DefaultController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::getAlias('@web').'/images/imperavi/ldscr/', // Directory URL address, where files are stored.
                'path' => 'images/imperavi/ldscr/', // Or absolute path to directory where files are stored.
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => Yii::getAlias('@web').'/images/imperavi/ldscr/', // Directory URL address, where files are stored.
                'path' => 'images/imperavi/ldscr/', // Or absolute path to directory where files are stored.
                'type' => '0',
            ],
            /*
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => 'files/blog/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/blog/', // Or absolute path to directory where files are stored.
                'type' => '1',//GetAction::TYPE_FILES,
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/files/blog/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/blog/' // Or absolute path to directory where files are stored.
            ],
            */
        ];
    }

    public function actionImperaviImageDelete(){
        if (Yii::$app->request->isAjax && Yii::$app->request->post('url')){
            $path_parts = pathinfo(Yii::$app->request->post('url'));
            $path = Yii::getAlias('@webroot') . '/images/imperavi/ldscr/' . $path_parts['basename'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionDeleteImage()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post('key', -1) >= 0) {
            $changeMain=false;
            $image = Image::findOne((int)Yii::$app->request->post('key'));
            if ($image->isMain==1){
                $changeMain = true;
            }
            $product = Products::findOne((int)Yii::$app->request->post('idmodel'));
            if ($product){
                $product->removeImage($image);
                //Если изображение главное - меняем его
                $newMainImg = Image::find()
                    ->where('itemId = :idmodel',[':idmodel'=>$product->id])
                    ->orderBy(['id' => SORT_ASC])
                    ->one()
                ;
                if ($newMainImg){
                    $newMainImg->isMain = 1;
                    $newMainImg->save();
                }
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $items = [];
            return $items;
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $items = ['error' => ['Ошибка удаления. Обратитесь к администратору.']];
            return $items;
        }
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->request->isPost) {
            $model->images = UploadedFile::getInstances($model, 'images');
            foreach ($model->images as $image) {
                $model->uploadImage($image);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isPost && $model->save()) {
            $model->images = UploadedFile::getInstances($model, 'images');
            foreach ($model->images as $image) {
                $model->uploadImage($image);
            }
            Yii::$app->getSession()->setFlash('productSaved',[
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Сохранение товара выполнено успешно',
                'title' =>  'Данные сохранены!',
                'icon' => 'glyphicon glyphicon-ok-sign',
                'positonY' => 'top',
                'positonX' => 'right'
            ]);

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $product = $this->findModel($id);
        $images = $product->getImages();
        foreach ($images as $image) {
            $product->removeImage($image);
        }
        $product->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
