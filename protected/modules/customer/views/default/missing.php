<?php
$this->breadcrumbs = array(
    Yii::t("translation", "dashboards") => array('index'),
    Yii::t("translation", "list"),
);
$id = $model->id;
?>


<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "dashboards"); ?></h1>
    </div>   
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">                          
            <div class="panel-body">                
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo CHtml::link('<i class="fa fa-arrow-left"></i>', array('default/index'), array('class' => 'btn btn-default')); ?>  
                        <?php echo CHtml::link('<i class="fa fa-arrow-right"></i>', array('default/image', 'id' => $model->id), array('class' => 'btn btn-default')); ?>  
                    </div>
                    <div class="col-lg-6 text-right">
                        <?php echo CHtml::link('<i class="fa fa-download"></i>', array('scoring/export', 'id' => $model->id), array('class' => 'btn btn-default')); ?>  
                    </div>
                </div>
            </div>                            
        </div>                       
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "list"); ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php
                if (isset($_GET['page_size'])) {
                    $page_size = (int) $_GET['page_size'];
                } else {
                    $page_size = 10;
                }
                ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo Yii::t("translation", "number_of_rows"); ?> <span class="badge"><?php echo $page_size; ?></span> <span class="caret"></span>
                    </button>                 

                    <ul class="dropdown-menu">                 
                        <li><?php echo CHtml::link('10', array('default/missing', 'id' => $id, 'page_size' => 10)); ?></li>
                        <li><?php echo CHtml::link('100', array('default/missing', 'id' => $id, 'page_size' => 100)); ?></li>
                        <li><?php echo CHtml::link('500', array('default/missing', 'id' => $id, 'page_size' => 500)); ?></li>
                        <li><?php echo CHtml::link('1000', array('default/missing', 'id' => $id, 'page_size' => 1000)); ?></li>
                        <li><?php echo CHtml::link('5000', array('default/missing', 'id' => $id, 'page_size' => 5000)); ?></li>                       
                    </ul>
                </div>

                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider' => $models,
                    'columns' => array(
                        array(
                            'name' => Yii::t("translation", "storename"),
                            'value' => '$data->storename',
                        ),
//                        array(
//                            'name' => Yii::t("translation", "sellers"),
//                            'value' => '$data->user->name',
//                        ),
                        array(
                            'name' => Yii::t("translation", "store_category_id"),
                            'value' => '$data->storeCategory->title',
                        ),
                        array(
                            'name' => Yii::t("translation", "tags"),
                            'value' => '$data->AllTags',
                        ),
                        array(
                            'name' => Yii::t("translation", "score"),
                            'value' => '$data->getPercent(' . $id . ')',
                        ),
//                        array(// display a column with "view", "update" and "delete" buttons
//                            'class' => 'CButtonColumn',
//                        ),
                    ),
                ));
                ?>                                                                      
            </div>         
        </div>      
    </div>   
</div>