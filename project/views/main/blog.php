<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 18.09.2015
 * Time: 16:22
 */
$this->title = 'Blog';
$this->params['breadcrumbs'][] = $this->title;

foreach ($models as $model) {

    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="panel-title text-left">
                        <?= $model->title ?>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <h5 class="panel-title text-right">
                        <?= $model->created_at ?>
                    </h5>
                </div>
            </div>

        </div>
        <div class="panel-body">
            <?= $model->article ?>
        </div>
    </div>

<?php } ?>