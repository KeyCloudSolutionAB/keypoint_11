
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'dashboard-form',
    'enableAjaxValidation' => false,
        ));
?>


<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title'); ?>
    <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div class="form-group date_box">
    <?php // echo $form->labelEx($model, 'date_begin'); ?>        
    <?php
//    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//        'attribute' => 'date_begin',
//        'model' => $model,
//        'language' => Yii::app()->language,
//        'options' => array(
//            'showWeek' => 'true',
//            'dateFormat' => 'dd.mm.yy',
//            'showAnim' => 'fold',
//            'onClose' => 'js:function(selectedDate){$("#Dashboard_date_end").datepicker("option", "minDate", selectedDate);}',
//        ),
//        'htmlOptions' => array(
//            'class' => 'form-control'
//        ),
//    ));
    ?>
    <?php // echo $form->error($model, 'date_begin'); ?>
</div>

<div class="form-group date_box margin_right_null">
    <?php // echo $form->labelEx($model, 'date_end'); ?>
    <?php
//    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//        'attribute' => 'date_end',
//        'model' => $model,
//        'language' => Yii::app()->language,
//        'options' => array(
//            'showWeek' => 'true',
//            'dateFormat' => 'dd.mm.yy',
//            'showAnim' => 'fold',
//            'onClose' => 'js:function(selectedDate){$("#Dashboard_date_begin").datepicker("option", "maxDate", selectedDate);}',
//        ),
//        'htmlOptions' => array(
//            'class' => 'form-control'
//        ),
//    ));
    ?>     
    <?php // echo $form->error($model, 'date_end'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'status'); ?>
    <?php echo $form->dropDownList($model, 'status', $model->getStatus(), array('class' => 'form-control')); ?>   
    <?php echo $form->error($model, 'status'); ?>
</div>


<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "create") : Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>


<?php $this->endWidget(); ?>

