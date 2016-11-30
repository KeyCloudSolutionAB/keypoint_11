<div class="row">  
    <div class="col-lg-12 margin_top_10 margin_bottom_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('store/view', 'id' => $store_model->id, 'scoring' => $scoring_model->id), array('class' => 'btn btn-default')); ?>

        <h3><?php echo $scoring_model->title; ?>:  <?php echo Yii::t("translation", "add_note"); ?></h3>

        <?php $this->widget('application.extensions.MenuForms.MenuForms', array('model' => $store_model, 'scoring_model' => $scoring_model)); ?> 

        <?php // echo CHtml::link('<i class="fa fa-image"></i> <span class="badge">' . count($scoring_model->Images) . '</span>', array('scoring/image', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>
        <?php // echo CHtml::link('<i class="fa fa-sticky-note-o"></i>', array('scoring/note', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>
        <?php // echo CHtml::link('<i class="fa fa-camera"></i> <span class="badge">' . count($scoring_model->UploadImages) . '</span>', array('scoring/upload_images', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>

        <?php $form = $this->beginWidget('CActiveForm', array('id' => 'answer-note-form')); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'note'); ?>
            <?php echo $form->textArea($model, 'note', array('class' => 'form-control')); ?>         
        </div>

        <button name="save" class="btn btn-default btn-block"><i class="fa fa-save"></i> <?php echo Yii::t("translation", "save"); ?></button>                

        <?php $this->endWidget(); ?>

    </div>
    <!-- /.col-lg-12 -->                   
</div>