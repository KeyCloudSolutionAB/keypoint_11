<?php
$this->breadcrumbs = array(
    Yii::t("translation", "stores") => array('index'),
    $model->storename,
);

$this->menu = array(
    array('label' => '<i class="fa fa-plus"></i>', 'url' => array('create'), 'encodeLabel' => FALSE),
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
    array('label' => Yii::t("translation", "update"), 'url' => array('update', 'id' => $model->id)),
);
?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "view"); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">     
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "view"); ?>
            </div>           
            <div class="panel-body">
                <?php
                $this->widget('zii.widgets.CDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'id',
                        array(
                            'name' => 'store_category_id',
                            'value' => $model->storeCategory->Name,
                        ),
                        array(
                            'name' => 'sellers',
                            'value' => $model->AllSellers,
                        ),
                        array(
                            'name' => 'tags',
                            'value' => $model->AllTags,
                        ),
                        'storename',
                        'adress',
                        'zip',
                        'phone',
                        'email',
                        'note',
                        'lang',
                        'create_time',
                        'update_time',
                        'city',
                        array(
                            'name' => 'status',
                            'value' => $model->setStatus($model->status),
                        ),
                    ),
                ));
                ?>
            </div>           
        </div>
    </div>
</div>


