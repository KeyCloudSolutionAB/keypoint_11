<?php
$this->breadcrumbs = array(
    Yii::t("translation", "store_category") => array('index'),
    Yii::t("translation", "update"),
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
    array('label' => Yii::t("translation", "view"), 'url' => array('view', 'id' => $model->id)),
);
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "update"); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">     
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "update"); ?>
            </div>           
            <div class="panel-body">
                <?php $this->renderPartial('_form', array('model' => $model)); ?>                               
            </div>           
        </div>
    </div>
</div>

