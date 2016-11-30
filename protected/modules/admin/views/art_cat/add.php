<?php
$this->breadcrumbs = array(
    Yii::t("translation", "art_cats") => array('index'),
    Yii::t('translation', 'add'),
);

$this->menu = array(
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
);
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add"); ?></h1>
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

        <?php $this->renderPartial('_cat', array('model' => $model)); ?>       
        <hr>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "add"); ?>
            </div>           
            <div class="panel-body">                
                <div class="table-responsive">                    
                    <?php $this->renderPartial('_add', array('models' => $models, 'store_category_id' => $store_category_id)); ?>                    
                </div>
            </div>           
        </div>
    </div>