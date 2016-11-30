<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'art-cat-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'article_id'); ?>
    <?php echo $form->textField($model, 'article_id', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'article_id'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'store_category_id'); ?>
    <?php echo $form->textField($model, 'store_category_id', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'store_category_id'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'value'); ?>
    <?php echo $form->textField($model, 'value', array('class' => 'form-control', 'size' => 5, 'maxlength' => 5)); ?>
    <?php echo $form->error($model, 'value'); ?>
</div>


<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>
