<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "list"),
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#scoring-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "list"); ?></h1>
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
                <?php echo Yii::t("translation", "list"); ?>
            </div>           
            <div class="panel-body">              
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'scoring-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'name' => 'id',
                            'htmlOptions' => array('style' => 'width: 30px'),
                        ),
                        'title',
                        'start_time',
                        'end_time',
//                        'note',
//                        'lang',
                        array(
                            'name' => '',
                            'htmlOptions' => array('style' => 'width: auto'),
                            'type' => 'raw',
                            'value' => '$data->status == "-1" ? "<i title=\"' . Yii::t("translation", "archive") . '\" class=\"fa fa-archive\"></i>" : "" ',
                            'filter' => FALSE,
                        ),
//                        'status',
                        /*

                          'user_id',
                         */
                        array(
                            'class' => 'ext.TbButtonColumn',
                            'template' => '{view}{update}{archive}{delete}',
                            'buttons' => array
                                (
                                'archive' => array
                                    (
                                    'label' => '<i class="fa fa-archive"></i>',
                                    'imageUrl' => FALSE,
                                    'url' => 'Yii::app()->createUrl("admin/scoring/archive", array("id"=>$data->id))',
                                    'options' => array(
                                        'title' => Yii::t("translation", "archive")
                                    ),
                                ),
                            ),
                        ),
                    ),
                ));
                ?>
            </div>           
        </div>
    </div>
</div>
