<?php

use yii\db\Schema;
use yii\db\Migration;

class m150907_095914_first_install extends Migration
{
    public function up()
    {
        $this->createTable('products', [
            'id' => Schema::TYPE_PK,
            'sdesc' => Schema::TYPE_STRING,
            'ldesc' => Schema::TYPE_TEXT,
            'price' => Schema::TYPE_FLOAT . ' NOT NULL DEFAULT \'0\'',
            'archive' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT \'0\'',
            'created_at' => Schema::TYPE_DATE,
            'updated_at' => Schema::TYPE_DATE,
            'paypal_button_code' => Schema::TYPE_TEXT,
        ],'DEFAULT CHARSET=utf8');

        $this->createTable('blog', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'article' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_DATE,
            'updated_at' => Schema::TYPE_DATE,
        ],'DEFAULT CHARSET=utf8');

        $this->createTable('orders', [
            'id' => Schema::TYPE_PK,
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'quantity' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'cost' => Schema::TYPE_FLOAT . ' NOT NULL DEFAULT \'0\'',
            'email' => Schema::TYPE_STRING,
            'comment' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_DATE,
            'updated_at' => Schema::TYPE_DATE,
        ],'DEFAULT CHARSET=utf8');

        $this->createTable('image', [
            'id' => 'pk',
            'filePath' => 'VARCHAR(400) NOT NULL',
            'itemId' => 'int(20) NOT NULL',
            'isMain' => 'int(1)',
            'modelName' => 'VARCHAR(150) NOT NULL',
            'urlAlias' => 'VARCHAR(400) NOT NULL',
        ]);

    }

    public function down()
    {
        $this->dropTable('products');
        $this->dropTable('blog');
        $this->dropTable('orders');
        $this->dropTable('image');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
