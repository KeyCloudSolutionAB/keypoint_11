<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'scoring-image-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'class' => 'upload_image',
        'enctype' => 'multipart/form-data'
    )
        )
);
?>


<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'image'); ?>
    <?php echo $form->fileField($model, 'image'); ?>
    <?php echo $form->error($model, 'image'); ?>
</div>

<?php echo CHtml::submitButton(Yii::t("translation", "add"), array('class' => 'btn btn-default')); ?>   

<?php $this->endWidget(); ?>