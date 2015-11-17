<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 06.10.2015
 * Time: 16:21
 */
namespace app\models;

class Mail extends \yii\base\Model
{
    public $body;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['email'], 'required'],
            ['body','safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'body' => 'Text',
        ];
    }
}
