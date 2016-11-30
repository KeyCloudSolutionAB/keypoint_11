<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customer-form',
    'enableAjaxValidation' => false,
        ));
?>


<?php echo $form->errorSummary($model); ?>

<div class="form-group">    
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'name'); ?>
</div>


<div class="form-group">
    <?php echo $form->labelEx($model, 'contact_name'); ?>
    <?php echo $form->textField($model, 'contact_name', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'contact_name'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'email'); ?>
</div>

<?php
if ($model->isNewRecord) {
    echo '<div class="form-group">';
    echo $form->labelEx($model, 'password');
    echo $form->passwordField($model, 'password', array('class' => 'form-control'));
    echo $form->error($model, 'password');
    echo '</div>';
}
?>



<div class="form-group">
    <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'phone'); ?>
</div>

<!--<div class="form-group">
<?php //echo $form->labelEx($model, 'team_id'); ?>
<?php //echo $form->dropDownList($model, 'team_id', $model->getTeamId(), array('class' => 'form-control')); ?>   
<?php //echo $form->error($model, 'team_id'); ?>
</div>-->

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
    <?php echo $form->dropDownList($model, 'lang', $model->getLang(), array('class' => 'form-control')); ?>   
    <?php echo $form->error($model, 'lang'); ?>
</div>

<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>