<?php
$this->breadcrumbs = array(
    Yii::t("translation", "settings"),
);

//$this->menu = array(
//    array('label' => Yii::t("translation", "settings"), 'url' => array('create')),
//);
?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "settings"); ?></h1>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "settings"); ?>
            </div>           
            <div class="panel-body">                
                <?php echo CHtml::link(Yii::t("translation", "share_dashboard"), array('dashboard/index'), array('class' => 'btn btn-default')); ?>
            </div>           
        </div>
    </div>
</div>