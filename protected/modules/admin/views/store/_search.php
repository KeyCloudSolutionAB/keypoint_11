<div class="well">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array('class' => 'form-inline'),
    ));
    ?>

    <div class="form-group">  
        <?php echo $form->textField($model, 'storename', array('class' => 'form-control', 'placeholder' => Yii::t("translation", "search_storename"))); ?>
    </div>

    <?php echo CHtml::submitButton(Yii::t("translation", "search"), array('class' => 'btn btn-default')); ?>

    <?php $this->endWidget(); ?>
</div>