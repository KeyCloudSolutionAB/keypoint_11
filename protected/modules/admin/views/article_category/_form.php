<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'article-category-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title'); ?>
    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>


<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>
