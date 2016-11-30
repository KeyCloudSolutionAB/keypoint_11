<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'art-cat-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'class' => 'form-inline'
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'store_category_id'); ?>
    <?php echo $form->dropDownList($model, 'store_category_id', $model->AllStoreCategory, array('class' => 'form-control')); ?>   
    <?php echo $form->error($model, 'store_category_id'); ?>
</div>

<?php echo CHtml::submitButton(Yii::t("translation", "choose"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>
