<?php

namespace app\controllers;

use app\models\Card;
use app\models\Orders;
use app\models\Products;
use app\models\Mail;
use yii\web\NotFoundHttpException;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\Blog;


class MainController extends Controller
{

    public $defaultAction = 'about';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
     * Функция записи данных о заказе
     */
    private function saveOrder($email, $comment)
    {
        $orders = array();
        $models = \Yii::$app->cart->getPositions();
        foreach ($models as $model) {
            $order = new Orders();
            $order->id_product = $model->id;
            $order->cost = (int)$model->getQuantity() * (float)$model->price;
            $order->quantity = (int)$model->getQuantity();
            if ($email) {
                $order->email = $email;
            }
            if ($comment) {
                $order->comment = $comment;
            }
            if ($order->save()) {
                $orders[] = $order;
                $this->addProductToArchive($model->id);
            }
        }
        return $orders;
    }

    /*
     * Функция добавления товара в архив после заказа
     */
    private function addProductToArchive($id)
    {
        $product = Products::findOne($id);
        if (!$product || $product->archive) {
            $this->setFlash('Sorry, product with ID = ' . $id . ' has already ordered.', 'warning', 'Not complete!');
            return $this->redirect(['cart']);
        } else {
            $product->archive = 1;
            $product->save();
        }
    }
    /*
     * Функция отправки почты
     */
    private function sendMail($email='',$body=''){
        return
            Yii::$app->mailer->compose()
                ->setFrom('c11693@c11693.shared.hc.ru')
                ->setTo('familialvalues@mail.ru')
                ->setSubject('Письмо из интернет-магазина')
                ->setHtmlBody($body .' <br><br> e-mail: '.$email)
                ->send();
        /*
        if (Yii::$app->mailer->compose()
            ->setFrom('c11693@c11693.shared.hc.ru')
            ->setTo('familialvalues@mail.ru')
            ->setSubject('Письмо из интернет-магазина')
            ->setHtmlBody($body .' <br><br> e-mail: '.$email)
            ->send()
        )
        {
            if ($hasFlash){
                $this->setFlash('Email send success.');
            }
        } else {
            if ($hasFlash) {
                $this->setFlash('Sorry, error while sending mail', 'warning', 'Not complete!');
            }
        }
        */
    }
    /*
    * Action отправки Email
    */
    public function actionEmail()
    {
        $model = new Mail();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($this->sendMail($model->email,$model->body)){
                $this->setFlash('Email send success.');
            } else {
                $this->setFlash('Sorry, error while sending mail', 'warning', 'Not complete!');
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        throw new NotFoundHttpException();
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionGallery()
    {
        $models = Products::find()->all();
        return $this->render('gallery', ['models' => $models]);
    }

    public function actionBearInfo($id)
    {
        $id = (int)$id;
        if (Yii::$app->request->isGet && $id > 0) {
            $model = Products::findOne($id);
            return $this->render('bear-info', ['model' => $model]);
        }
    }


    public function actionCatalog()
    {
        $query = Products::find();
        $pagination = new Pagination([
            'defaultPageSize' => 9,
            'totalCount' => $query->count(),
        ]);

        $models = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->andWhere('archive=:archive', [':archive' => '0'])
            ->all();


        return $this->render('catalog', [
            'models' => $models,
            'pagination' => $pagination,
        ]);
    }

    public function actionBlog()
    {
        $models = Blog::find()
            ->all();
        return $this->render('blog', ['models' => $models]);
    }

    /*
     * Вывод всплывающих сообщений
     */
    private function setFlash($text, $type = 'success', $title = 'Complete!')
    {
        Yii::$app->getSession()->setFlash('productSaved', [
            'type' => $type,
            'duration' => 3000,
            'message' => $text,
            'title' => $title,
            // 'icon' => 'glyphicon glyphicon-ok-sign',
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
    }

    /*
     * Метод добавления товавра в корзину
     */
    public function actionAddToCart($id)
    {
        $model = Products::findOne((int)$id);
        if ($model) {
            if (\Yii::$app->cart->getPositionById($id) == null) {
                \Yii::$app->cart->put($model, 1);
                $this->setFlash('Adding to cart complete');
            } else {
                $this->setFlash('This product has already in cart!', 'warning', 'Not complete!');
            }

            return $this->redirect(Yii::$app->request->referrer);
        }
        throw new NotFoundHttpException();
    }

    /*
    * Метод очистки корзины
    */
    public function actionClearCart()
    {
        \Yii::$app->cart->removeAll();
        $this->setFlash('Cart has cleared');
        return $this->redirect(['catalog']);
    }


    /*
     * Action обработки заказа
     */
    public function actionOrder()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('Orders');
            $msg = "
                <table><thead><tr>
                <th>ID</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Email</th>
                <th>Comment</th>
                </tr></thead><tbody>
                ";
            $models = \Yii::$app->cart->getPositions();
            foreach ($models as $model) {
                $cost = (int)$model->getQuantity() * (float)$model->price;
                $msg .= "<tr>";
                $msg .= "<td>" . $model->id . "</td>";
                $msg .= "<td>" . $model->sdesc . "</td>";
                $msg .= "<td>" . $model->price . "</td>";
                $msg .= "<td>" . $model->getQuantity() . "</td>";
                $msg .= "<td>" . $cost . "</td>";
                $msg .= "<td>" . $post['email'] . "</td>";
                $msg .= "<td>" . $post['comment'] . "</td>";
                $msg .= "</tr>";
            }
            if ($this->saveOrder($post['email'], $post['comment'])) {
                $this->sendMail('',$msg);
                \Yii::$app->cart->removeAll();
                $this->setFlash('Order complete');
            } else {
                $this->setFlash('Sorry, error occured while saving order', 'warning', 'Not complete!');
            }
        }
        return $this->redirect(['catalog']);
    }

    /*
    * Метод отображения корзины и обработки заказа
    */
    public function actionCart()
    {
        $cart = \Yii::$app->cart->getPositions();
        $order = new Orders();
        $card = new Card();
        return $this->render('cart', ['cart' => $cart, 'order' => $order, 'card' => $card]);
    }


}
