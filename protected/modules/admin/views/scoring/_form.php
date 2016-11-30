<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'scoring-form',
    'enableAjaxValidation' => false,
        ));
?>


<?php echo $form->errorSummary($model); ?>

<div class="col-lg-6">
    <div class="form-group">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="form-group date_box">
        <?php echo $form->labelEx($model, 'start_time'); ?>        
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'attribute' => 'start_time',
            'model' => $model,
            'language' => Yii::app()->language,
            'options' => array(
                'showWeek' => 'true',
                'dateFormat' => 'dd.mm.yy',
                'showAnim' => 'fold',
                'onClose' => 'js:function(selectedDate){$("#Scoring_end_time").datepicker("option", "minDate", selectedDate);}',
            ),
            'htmlOptions' => array(
                'class' => 'form-control'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'start_time'); ?>
    </div>

    <div class="form-group date_box margin_right_null">
        <?php echo $form->labelEx($model, 'end_time'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'attribute' => 'end_time',
            'model' => $model,
            'language' => Yii::app()->language,
            'options' => array(
                'showWeek' => 'true',
                'dateFormat' => 'dd.mm.yy',
                'showAnim' => 'fold',
                'onClose' => 'js:function(selectedDate){$("#Scoring_start_time").datepicker("option", "maxDate", selectedDate);}',
            ),
            'htmlOptions' => array(
                'class' => 'form-control'
            ),
        ));
        ?>     
        <?php echo $form->error($model, 'end_time'); ?>
    </div>
</div>   

<div class="col-lg-6">
    <div class="form-group">
        <?php echo $form->labelEx($model, 'note'); ?>
        <?php echo $form->textArea($model, 'note', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'note'); ?>
    </div> 
</div>


<div class="col-lg-12">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t("translation", "add_and_next") : Yii::t("translation", "update"), array('class' => 'btn btn-primary')); ?>   
</div>




<?php $this->endWidget(); ?>

