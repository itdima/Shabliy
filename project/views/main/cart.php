<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 18.09.2015
 * Time: 11:39
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;



if ($cart) {
?>


<div class='bodoni'>
    <table class="table">
        <thead>
        <tr>
            <th>Foto</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Cost</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($cart as $model) {
            echo '<tr>';
            echo '<td>' . Html::img($model->getImage()->getUrl('x100')) . '</td>';
            echo '<td>' . $model->sdesc . '</td>';
            echo '<td>' . $model->price . '</td>';
            echo '<td>' . $model->getQuantity() . '</td>';
            echo '<td>' . (int)$model->getQuantity() * (float)$model->price . '</td>';
        }
        ?>
        </tbody>
    </table>

    <div class="table text-right">
        <a id="showModalOrder" href="#"
           class="btn btn-default btn-sm" data-toggle="modal" data-target="#order">
            <h4> Make order </h4>
        </a>
        <a id="clear" href="<?= URL::toRoute('clear-cart'); ?>"
           class="btn btn-default btn-sm">
            <h4> Clear cart </h4>
        </a>
    </div>

    <?php
    } else {
        echo '<span>Cart is empty!</span>';
    }
    ?>
</div>

<div id="order" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Order's Form</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['action' => ['main/order'],'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($order, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($order, 'comment')->textarea(['maxlength' => true]) ?>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <?= Html::submitButton('Make order', ['class' => 'btn btn-default']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>