<div class="row">

    <div class="col-lg-12 margin_top_10">

        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), '/', array('class' => 'btn btn-default')); ?>


        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <div class="margin_bottom_10 text-center"> 
            <h3><?php echo Yii::t("translation", "change_personal_data"); ?></h3>
        </div>  
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