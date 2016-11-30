<?php
$this->breadcrumbs = array(
    Yii::t("translation", "change_personal_data") => array('index'),
);
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "change_personal_data"); ?></h1>
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
        <div class="panel panel-default">                   
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    'enableAjaxValidation' => false,
                ));
                ?>


                <?php echo $form->errorSummary($model); ?>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'new_pass'); ?>
                    <?php echo $form->passwordField($model, 'new_pass', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'new_pass'); ?>
                </div>       

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'contact_name'); ?>
                    <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>     

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phone'); ?>
                    <?php echo $form->textField($model, 'phone', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                </div>   

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'lang'); ?>
                    <?php echo $form->dropDownList($model, 'lang', $model->getLang(), array('class' => 'form-control')); ?>   
                    <?php echo $form->error($model, 'lang'); ?>
                </div>


                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


                <?php $this->endWidget(); ?>
            </div>           
        </div>
    </div>
</div>