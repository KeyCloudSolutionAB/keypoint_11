<?php
$this->breadcrumbs = array(
    Yii::t("translation", "seller") => array('index'),
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
	$('#user-grid').yiiGridView('update', {
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
                    'id' => 'user-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'name' => 'team_id',
                            'value' => '$data->setTeamId($data->team_id)',
                            'type' => 'raw',
                            'filter' => CHtml::dropDownList('Seller[team_id]', 'Seller[team_id]', $model->TeamId, array('class' => 'form-control', 'empty' => '')),
                        ),
                        array(
                            'name' => 'name',
                            'type' => 'raw',
                            'value' => 'CHtml::link($data->name, array("seller/view", "id"=>$data->id));',
                        ),
                        'email',
//                        array(
//                            'name' => 'id',
//                            'htmlOptions' => array('style' => 'width: 30px'),
//                        ),
//                        array(
//                            'name' => 'email',
//                            'type' => 'raw',
//                            'value' => 'CHtml::link($data->email, array("user/view", "id"=>$data->id));',
//                        ),
                        'phone',
//                        array(
//                            'name' => 'role',
//                            'value' => '$data->setRole($data->role)',
//                        ),
                        array(
                            'name' => 'status',
                            'value' => '$data->setStatus($data->status)',
                        ),
//                        array(
//                            'name' => 'create_time',
//                            'value' => 'date("Y-m-d", strtotime($data->create_time))',
//                        ),
                        /*



                          'note',
                          'date_entry',
                          'registration_code',
                          'recover_password',
                          'team_id',
                         */
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
                                    'url' => 'Yii::app()->createUrl("customer/seller/send_mail", array("id"=>$data->id))',
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

