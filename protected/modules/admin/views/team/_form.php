<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'team-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'user_id'); ?>
    <?php echo $form->textField($model, 'user_id', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'user_id'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'team_name_id'); ?>
    <?php echo $form->textField($model, 'team_name_id', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'team_name_id'); ?>
</div>


<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>

