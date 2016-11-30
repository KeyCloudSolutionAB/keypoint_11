<div class="row">  
    <div class="col-lg-12 margin_top_10 margin_bottom_10">     

        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('site/index'), array('class' => 'btn btn-default')); ?>

        <h3><?php echo $model->title; ?>:  <?php echo Yii::t("translation", "images"); ?></h3>

        <?php
        if (!empty($images)) {
            foreach ($images as $key => $value) {
                $url = CHtml::normalizeUrl(array('my_scoreing/one_image', 'id' => $model->id, 'image_id' => $value->id));
                ?>
                <div class="width_all_images text-center">
                    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $value->image, empty($value->title) ? "" : $value->title, array('class' => 'img-thumbnail')), $url, array('class' => 'block')); ?>
                    <?php
//                    echo $value->scoringImageUpload->description;
                    ?>     
                    <div class="small">
                        <?php echo $value->totalScoring->store->storename; ?>    
                    </div>

                </div>


                <?php
            }
        }
        ?>

        <?php
        if (FALSE) {
            // Это можно удалить потом
            ?>
            <div id="carousel-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php
                    foreach ($images as $key => $value) {
                        if ($key == 0) {
                            echo '<li data-target="#carousel-generic" data-slide-to="0" class="active"></li>';
                        } else {
                            echo '<li data-target="#carousel-generic" data-slide-to="' . $key . '"></li>';
                        }
                    }
                    ?>                 
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php
                    foreach ($images as $key => $value) {
                        $url = CHtml::normalizeUrl(array('my_scoreing/one_image', 'id' => $model->id, 'image_id' => $value->id));
                        if ($key == 0) {
                            echo '<div class="item active">';
                            echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $value->image, empty($value->title) ? "" : $value->title), $url);
                            echo '</div>';
                        } else {
                            echo '<div class="item">';
                            echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $value->image, empty($value->title) ? "" : $value->title), $url);
                            echo '</div>';
                        }
                    }
                    ?>              
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo Yii::t("translation", "previous"); ?></span>
                </a>
                <a class="right carousel-control" href="#carousel-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo Yii::t("translation", "next"); ?></span>
                </a>
            </div>  
        <?php } ?>
    </div>
    <!-- /.col-lg-12 -->                   
</div>