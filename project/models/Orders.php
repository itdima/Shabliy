<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $id_product
 * @property integer $quantity
 * @property double $cost
 */
class Orders extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
               // 'attributes' => [
                   // ActiveRecord::EVENT_BEFORE_INSERT => 'creation_time',
                   // ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
              //  ],
                //'value' => function() { return date('U'); },
                    ],
                    ];
                }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity'], 'integer'],
            [['id_product'], 'integer'],
            [['cost'], 'number'],
            [['email'], 'email'],
            [['email'], 'required'],
            [['comment'], 'string','max' => 255],
            [['created_at','updated_at'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_product' => 'ID Products',
            'quantity' => 'Quantity',
            'cost' => 'Cost',
            'email' => 'email',
            'comment' => 'Comments',
        ];
    }
}
