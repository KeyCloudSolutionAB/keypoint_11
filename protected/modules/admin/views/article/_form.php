<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'article-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'article_category_id'); ?>
    <?php echo $form->dropDownList($model, 'article_category_id', $model->AllArticleCategory, array('class' => 'form-control')); ?>   
    <?php echo $form->error($model, 'article_category_id'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title'); ?>
    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'article_id'); ?>
    <?php echo $form->textField($model, 'article_id', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'article_id'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'cpg'); ?>
    <?php echo $form->textField($model, 'cpg', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'cpg'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'ean'); ?>
    <?php echo $form->textField($model, 'ean', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
    <?php echo $form->error($model, 'ean'); ?>
</div>


<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>
