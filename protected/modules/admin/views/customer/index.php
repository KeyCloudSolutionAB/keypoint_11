<?php
$this->breadcrumbs = array(
    Yii::t("translation", "customers") => array('index'),
    Yii::t("translation", "list"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-plus"></i> <i class="fa fa-user"></i>', 'url' => array('create'), 'encodeLabel' => FALSE),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#customer-grid').yiiGridView('update', {
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
        <div class="well">
            <?php $this->renderPartial('_form_admin_choose', array('model' => $admin_choose)); ?>    
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "list"); ?>
            </div>           
            <div class="panel-body">

                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'customer-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'name' => 'name',
                            'type' => 'raw',
                            'value' => 'CHtml::link($data->name, array("customer/view", "id"=>$data->id));',
                        ),
                        'contact_name',
                        'email',
                        'phone',
                        array(
                            'name' => 'status',
                            'value' => '$data->setStatus($data->status)',
                        ),
                        array
                            (
                            'class' => 'ext.TbButtonColumn',
                            'template' => '{email} {update} {delete}',
                            'buttons' => array
                                (
                                'email' => array
                                    (
                                    'label' => '<i class="fa fa-envelope-o fa-lg"></i>',
                                    'imageUrl' => FALSE,
                                    'url' => 'Yii::app()->createUrl("admin/customer/send_mail", array("id"=>$data->id))',
                                    'options' => array('title' => Yii::t("translation", "send_mail")),
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