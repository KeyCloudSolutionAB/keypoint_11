<?php
$this->breadcrumbs = array(
    Yii::t("translation", "stores") => array('index'),
    Yii::t("translation", "statistics"),
    $model->storename,
);

$this->menu = array(
    array('label' => '<i class="fa fa-plus"></i>', 'url' => array('create'), 'encodeLabel' => FALSE),
    array('label' => Yii::t("translation", "view"), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
    array('label' => Yii::t("translation", "update"), 'url' => array('update', 'id' => $model->id)),
);
?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "statistics"); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-sm-6">     
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "statistics"); ?>
            </div>           
            <div class="panel-body">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'total-scoring-grid',
                    'dataProvider' => $dataProvider,
                    'columns' => array(
                        array(
                            'name' => Yii::t("translation", "scoring"),
                            'value' => '$data->scoring->title',
                        ),                        
                        'percent',
                        array(
                            'name' => Yii::t("translation", "name"),
                            'value' => '$data->user->name',
                        ),
                    ),
                ));
                ?>
            </div>           
        </div>
    </div>
    <div class="col-sm-6">     
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
                        'storename',
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
                    ),
                ));
                ?>
            </div>           
        </div>
    </div>
</div>


