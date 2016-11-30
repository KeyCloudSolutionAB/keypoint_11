<?php
$this->breadcrumbs = array(
    Yii::t("translation", "customers") => array('index'),
    $model->email,
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i>', 'url' => array('index'), 'encodeLabel' => FALSE),
    array('label' => '<i class="fa fa-plus"></i> <i class="fa fa-user"></i>', 'url' => array('create'), 'encodeLabel' => FALSE),
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
    array('label' => Yii::t("translation", "update"), 'url' => array('update', 'id' => $model->id)),
    array('label' => '<i class="fa fa-envelope-o"></i> ' . Yii::t("translation", "send_again"), 'url' => array('send_mail', 'id' => $model->id), 'encodeLabel' => FALSE),
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
                        'name',
                        'contact_name',
                        'email',
                        'phone',
                        'note',
                        'create_time',
                        'date_entry',
                        array(
                            'name' => 'status',
                            'value' => $model->setStatus($model->status),
                        ),
                        'registration_code',
                        'recover_password',
                        array(
                            'name' => 'role',
                            'value' => $model->setRole($model->role),
                        ),
                        'lang',
//                        array(
//                            'name' => 'team_id',
//                            'value' => empty($model->team_id) ? NULL : $model->setTeamId($model->team_id),
//                        ),
                    ),
                ));
                ?>                                      
            </div>           
        </div>
    </div>
</div>