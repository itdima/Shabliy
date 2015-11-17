<?php

namespace app\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;
use yii\db\Expression;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $sdesc
 * @property string $ldesc
 * @property double $price
 * @property integer $archive
 */
class Products extends \yii\db\ActiveRecord implements CartPositionInterface
{
    public $images;

    use CartPositionTrait;

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Прикрепление изображения к модели
     * @return image
     */
    public function uploadImage($image)
    {
        $tempName = Yii::$app->basePath . '/uploads/' . Yii::$app->security->generateRandomString() .'.'. $image->extension;
        $image->saveAs($tempName);
        $uploadedImage = $this->attachImage($tempName);
        if ($uploadedImage && file_exists($tempName)) {
            unlink($tempName);
        }
        return $uploadedImage;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['price'], 'number'],
            [['price'],'default', 'value' => 0],
            [['archive'], 'integer'],
            [['archive'],'default', 'value' => 0],
            [['sdesc'], 'string', 'max' => 255],
            [['ldesc'], 'string'],
            [['images'], 'file', 'maxFiles' => 0],
            [['created_at','updated_at','paypal_button_code'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sdesc' => 'Короткое описание',
            'ldesc' => 'Подробное описание',
            'price' => 'Цена',
            'archive' => 'В архив',
            'images' => 'Фото',
            'paypal_button_code' => 'Код кнопки PayPal'
        ];
    }
}
