<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "update"),
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
    array('label' => Yii::t("translation", "view"), 'url' => array('view', 'id' => $model->id)), 
);

$this->menu_right = array(
    array('label' => Yii::t("translation", "next") . ' <i class="fa fa-arrow-right"></i>', 'url' => array('add_store_category_tag', 'id' => $model->id), 'encodeLabel' => FALSE),
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
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <?php if (Yii::app()->user->hasFlash('error')) { ?>
            <div class="alert alert-danger">
                <?php echo Yii::app()->user->getFlash('error'); ?>     
            </div>
        <?php } ?>
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

