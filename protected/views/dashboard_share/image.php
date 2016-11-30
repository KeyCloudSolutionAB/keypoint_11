<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "share_dashboard"); ?></h1>
    </div>   
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">                          
            <div class="panel-body">
                <?php echo CHtml::link('<i class="fa fa-arrow-left"></i>', array('dashboard_share/index', 'key_id' => $model_dash->key), array('class' => 'btn btn-default')); ?>    
                <?php echo CHtml::link('<i class="fa fa-arrow-right"></i>', array('dashboard_share/top', 'id' => $model->id, 'key_id' => $model_dash->key), array('class' => 'btn btn-default')); ?>                  
            </div>                      
        </div>                       
        <div class="panel panel-default">
            <div class="panel-heading">
                List
            </div>
            <div class="panel-body">
                <ul class="list-unstyled list-inline list_image">
                    <?php
                    foreach ($models as $key => $value) {
                        $link = Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $value->image;
                        $model_image = AnswerUpload::model()->resetScope()->findByPk($value->id);
                        $total_model = TotalScoring::model()->resetScope()->findByPk($model_image->total_scoring_id);
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo $link; ?>">
                                <img src="<?php echo $link; ?>" alt="<?php echo $value->image; ?>" class="img-thumbnail">
                                <span><?php echo $total_model->store->storename; ?></span>
                            </a>
                        </li>
                    <?php } ?>                  
                </ul>                                                                                    
            </div>        
        </div>      
    </div>   
</div>