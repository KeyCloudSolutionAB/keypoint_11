<?php
$this->breadcrumbs = array(
    Yii::t("translation", "team") => array('index'),
    $model->user_id,
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
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
                        'user_id',
                        'team_name_id',
                    ),
                ));
                ?>
            </div>           
        </div>
    </div>
</div>

