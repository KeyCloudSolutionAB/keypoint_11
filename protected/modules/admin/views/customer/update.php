<?php
$this->breadcrumbs = array(
    Yii::t("translation", "customers") => array('index'),
    Yii::t("translation", "update"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i>', 'url' => array('index'), 'encodeLabel' => FALSE),
    array('label' => '<i class="fa fa-plus"></i> <i class="fa fa-user"></i>', 'url' => array('create'), 'encodeLabel' => FALSE),
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
    array('label' => Yii::t("translation", "view"), 'url' => array('view', 'id' => $model->id)),
    array('label' => '<i class="fa fa-envelope-o"></i> ' . Yii::t("translation", "send_again"), 'url' => array('send_mail', 'id' => $model->id), 'encodeLabel' => FALSE),
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

