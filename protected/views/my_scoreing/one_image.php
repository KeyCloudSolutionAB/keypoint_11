<div class="row">  
    <div class="col-lg-12 margin_top_10 margin_bottom_10">     

        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('my_scoreing/all_images', 'id' => $model->id), array('class' => 'btn btn-default')); ?>

        <h3><?php echo $model->title; ?>:  <?php echo Yii::t("translation", "images"); ?></h3>

        <?php if (!empty($image)) { ?>
            <div class="text-center">
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $image->image, empty($image->title) ? "" : $image->title, array('class' => 'img-thumbnail')); ?>
                <div class="small">
                    <?php echo $image->totalScoring->store->storename; ?>    
                </div>
            </div>
        <?php } ?>      
    </div>
    <!-- /.col-lg-12 -->                   
</div>