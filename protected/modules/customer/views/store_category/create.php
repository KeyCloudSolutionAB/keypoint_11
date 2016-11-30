<?php
$this->breadcrumbs = array(
    Yii::t("translation", "store_category") => array('index'),
    Yii::t("translation", "create"),
);

$this->menu = array(
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
);
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "create"); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">     
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "create"); ?>
            </div>           
            <div class="panel-body">
                <?php $this->renderPartial('_form', array('model' => $model)); ?>                               
            </div>           
        </div>
    </div>
</div>

