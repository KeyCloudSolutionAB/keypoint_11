<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'store-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'store_category_id'); ?>
    <?php echo $form->dropDownList($model, 'store_category_id', $model->getStoreCategoryId(), array('class' => 'form-control')); ?>   
    <?php echo $form->error($model, 'store_category_id'); ?>
</div>

<!-- tokenize -->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.tokenize.css" rel="stylesheet">

<div class="form-group">
    <?php echo $form->labelEx($model, 'sellers'); ?>
    <?php echo $form->dropDownList($model, 'sellers', $model->getSellers(), array('class' => 'tokenize tokenize_input', 'id' => 'sellers_tokenize', 'multiple' => 'multiple')); ?>   
    <?php echo $form->error($model, 'sellers'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'tags'); ?>
    <?php echo $form->dropDownList($model, 'tags', $model->getTags(), array('class' => 'tokenize tokenize_input', 'id' => 'tokenize', 'multiple' => 'multiple')); ?>   
    <?php echo $form->error($model, 'tags'); ?>
</div>

<!-- tokenize -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.tokenize.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sellers_tokenize').tokenize();
        $('#tokenize').tokenize();
    });

</script>

<div class="form-group">
    <?php echo $form->labelEx($model, 'storename'); ?>
    <?php echo $form->textField($model, 'storename', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'storename'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'adress'); ?>
    <?php echo $form->textField($model, 'adress', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'adress'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'zip'); ?>
    <?php echo $form->textField($model, 'zip', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'zip'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'phone'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'email'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'note'); ?>
    <?php echo $form->textArea($model, 'note', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'note'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'status'); ?>
    <?php echo $form->dropDownList($model, 'status', $model->getStatus(), array('class' => 'form-control')); ?>   
    <?php echo $form->error($model, 'status'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'lang'); ?>
    <?php echo $form->textField($model, 'lang', array('class' => 'form-control', 'disabled' => 'disabled')); ?>  
    <?php echo $form->error($model, 'lang'); ?>
</div>	

<div class="form-group">
    <?php echo $form->labelEx($model, 'city'); ?>
    <?php echo $form->textField($model, 'city', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'city'); ?>
</div>

<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>

