<div class="row">
    <div class="col-lg-12 margin_top_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>
        <div class="margin_bottom_10">    
            <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('/all_store'), array('class' => 'btn btn-default')); ?>

        </div>         

        <h3><?php echo $model->storename; ?></h3>       

        <div class="panel panel-default">                     
            <div class="panel-body">
                <?php $this->renderPartial('_form', array('model' => $model)); ?>                               
            </div>           
        </div>

    </div> 
    <!-- /.col-lg-12 -->                   
</div>