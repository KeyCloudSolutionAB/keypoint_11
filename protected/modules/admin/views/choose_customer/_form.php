<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'admin-choose-form',
    'enableAjaxValidation' => false,
        ));
?>


<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'customer_id'); ?>
    <?php echo $form->dropDownList($model, 'customer_id', $model->Customers, array('class' => 'form-control')); ?>   
    <?php echo $form->error($model, 'customer_id'); ?>
</div>


<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>

