<?php
$this->breadcrumbs = array(
    Yii::t("translation", "stores") => array('index'),
    Yii::t("translation", "store_importer"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-plus"></i>', 'url' => array('create'), 'encodeLabel' => FALSE),
);
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "store_importer"); ?></h1>
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
                <?php echo Yii::t("translation", "store_importer"); ?>             
            </div>                 
            <div class="panel-body">
                <div class="col-lg-6">   
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'enableAjaxValidation' => true,
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data'
                        )
                    ));
                    ?>              

                    <div class="form-group">              
                        <?php echo $form->labelEx($model, 'file'); ?>
                        <?php echo $form->fileField($model, 'file'); ?>   
                        <?php echo $form->error($model, 'file'); ?>                   
                    </div>

                    <?php echo CHtml::submitButton(Yii::t("translation", "import"), array('class' => 'btn btn-default')); ?>

                    <?php $this->endWidget(); ?>  
                </div> 
                <div class="col-lg-6">
                    <p><?php echo Yii::t("translation", "text_for_template_import_store"); ?></p>
                    <?php echo CHtml::link('<i class="fa fa-file-o"></i>', Yii::app()->request->baseUrl . '/upload_files/store_template.csv', array('class' => 'btn btn-default')); ?>
                </div>
            </div>                  
        </div>         
    </div>
</div>