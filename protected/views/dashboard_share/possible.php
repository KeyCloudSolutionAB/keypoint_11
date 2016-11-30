<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "share_dashboard"); ?></h1>
    </div>   
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">                          
            <div class="panel-body">
                <?php echo CHtml::link('<i class="fa fa-arrow-left"></i>', array('dashboard_share/index', 'key_id' => $model_dash->key), array('class' => 'btn btn-default')); ?> 
                <?php echo CHtml::link('<i class="fa fa-arrow-right"></i>', array('dashboard_share/image', 'id' => $model->id, 'key_id' => $model_dash->key), array('class' => 'btn btn-default')); ?>                  
            </div>                            
        </div>                       
        <div class="panel panel-default">
            <div class="panel-heading">
                List
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php
                $id = $model->id;
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
                            'value' => 'CHtml::encode($data->getPercent(' . $id . ')). "%"',
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