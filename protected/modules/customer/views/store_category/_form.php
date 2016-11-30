<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'store-category-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title'); ?>
    <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div class="form-group">
    <?php // echo $form->labelEx($model, 'translation_en'); ?>
    <?php // echo $form->textField($model, 'translation_en', array('class' => 'form-control')); ?>
    <?php // echo $form->error($model, 'translation_en'); ?>
</div>

<div class="form-group">
    <?php // echo $form->labelEx($model, 'translation_sv'); ?>
    <?php // echo $form->textField($model, 'translation_sv', array('class' => 'form-control')); ?>
    <?php // echo $form->error($model, 'translation_sv'); ?>
</div>

<div class="form-group">
    <?php // echo $form->labelEx($model, 'translation_no'); ?>
    <?php // echo $form->textField($model, 'translation_no', array('class' => 'form-control')); ?>
    <?php // echo $form->error($model, 'translation_no'); ?>
</div>

<div class="form-group">
    <?php // echo $form->labelEx($model, 'translation_da'); ?>
    <?php // echo $form->textField($model, 'translation_da', array('class' => 'form-control')); ?>
    <?php // echo $form->error($model, 'translation_da'); ?>
</div>

<div class="form-group">
    <?php // echo $form->labelEx($model, 'translation_fi'); ?>
    <?php // echo $form->textField($model, 'translation_fi', array('class' => 'form-control')); ?>
    <?php // echo $form->error($model, 'translation_fi'); ?>
</div>

<div class="form-group">
    <?php // echo $form->labelEx($model, 'translation_de'); ?>
    <?php // echo $form->textField($model, 'translation_de', array('class' => 'form-control')); ?>
    <?php // echo $form->error($model, 'translation_de'); ?>
</div>


<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>

