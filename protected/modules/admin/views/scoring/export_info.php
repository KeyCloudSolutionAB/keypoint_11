<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    $model->title,
);

$this->menu = array(
//    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
//    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
//    array('label' => Yii::t("translation", "update"), 'url' => array('update', 'id' => $model->id)),
);
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $model->title; ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12"> 
        <div class="panel panel-default">                          
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo CHtml::link('<i class="fa fa-arrow-left"></i>', array('default/view', 'id' => $model->id, 'mesured' => 'true'), array('class' => 'btn btn-default')); ?>  

                    </div>
                    <div class="col-lg-6 text-right">
                        <?php echo CHtml::link('<i class="fa fa-download"></i>', array('scoring/export', 'id' => $model->id), array('class' => 'btn btn-default')); ?> 
                    </div>
                </div>
            </div>                            
        </div>      
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "start_time"); ?>: <span class="label label-default"><?php echo $model->start_time; ?></span> | <?php echo Yii::t("translation", "end_time"); ?>: <span class="label label-default"><?php echo $model->end_time; ?></span>
            </div>           
            <div class="panel-body">       
                <div class="table-responsive">
                    <?php echo $table_string; ?>
                </div>               
            </div>   
            <div class="panel-footer">
                <?php echo Yii::t("translation", "note"); ?>: <?php echo $model->note; ?>
            </div>
        </div>
    </div>
</div>
