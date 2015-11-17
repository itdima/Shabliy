<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 08.10.2015
 * Time: 15:16
 */

namespace app\models;

class Card extends \yii\base\Model
{
    public $type;
    public $number;
    public $month;
    public $year;
    public $cvv;
    public $lname;
    public $fname;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['number','number'],
            ['number','string','length' =>16],
            ['type','string'],
            ['year','number'],
            ['year','string','length' =>4],
            ['month','number'],
            ['month','string','min' =>1, 'max'=>2],
            ['cvv','number'],
            ['cvv','string','length' =>3],
            ['fname','string'],
            ['lname','string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => 'Card number',
            'type'=>'Card type',
            'year' =>'Year expired',
            'month' =>'Month expired',
            'cvv'=>'cvv2',
            'fname'=>'First Name',
            'lname'=>'Last Name',
        ];
    }
}
