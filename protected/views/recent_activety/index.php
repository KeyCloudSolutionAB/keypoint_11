<div class="row">
    <div class="col-lg-12 margin_top_10">
        <div class="margin_bottom_10 text-center">    
            <div class="btn-group" role="group">
                <?php echo CHtml::link(Yii::t("translation", "my_scoreing"), array('site/index'), array('class' => 'btn btn-default')); ?>
                <?php echo CHtml::link(Yii::t("translation", "recent_activety"), '#', array('class' => 'btn btn-myprimary')); ?>  
            </div>
        </div>  
        <hr>
        <?php
        $count = 0;
        foreach ($total_scorings as $key => $value) {
            $url = "#";
            ?>
            <div class="col-xs-6">
                <?php
                $image = $value->lastUploadImage();
                if (!empty($image)) {
                    echo CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $image->image, $image->image, array('style' => 'width: 100%', 'class' => 'img-thumbnail'));
                } else {
                    echo CHtml::image(Yii::app()->request->baseUrl . '/images/no-thumb.png', 'No image', array('style' => 'width: 100%', 'class' => 'img-thumbnail'));
                }
                ?>
                <?php if ($value->LastPercent > 0) { ?>
                    <span class="last_percent label label-success"><?php echo $value->LastPercent; ?></span>
                <?php } else { ?>
                    <span class="last_percent label label-danger"><?php echo $value->LastPercent; ?></span>
                <?php } ?>
            </div>
            <div class="col-xs-6">
                <div class="score_box_procent width100percent">
                    <div id="divProgress<?php echo $count; ?>"></div>
                    <script>
                        $(document).ready(function () {
                            $("#divProgress<?php echo $count; ?>").circularloader({
                                radius: 50,
                                progressPercent: <?php echo $value->percent; ?>,
                                backgroundColor: "#ffffff",
                                fontColor: "#18a657",
                                fontSize: "32px",
                                progressBarBackground: "#3d81da",
                                progressBarColor: "#18a657",
                                progressBarWidth: 6,
                                showText: true,
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12">                
                <p class="recent_activety_storename margin_bottom_0"><?php echo $value->NameScoring; ?></p>
                <p class="recent_activety_storename margin_bottom_0"><?php echo $value->store->storename; ?></p>

                <?php
                $note = AnswerNote::model()->resetScope()->findByAttributes(array('total_scoring_id' => $value->id));
                if (!empty($note)) {
                    ?>
                    <p>                         
                        <?php echo CHtml::encode($note->note); ?>
                    </p>
                <?php } ?>


                <p>
                    <?php echo $value->user->name; ?>,
                    <?php if (!empty($value->date_update)) { ?>                    
                        <?php echo date("d/m/Y H:i", strtotime($value->date_update)); ?>  
                    <?php } ?>
                </p>

            </div>
            <div class="clearfix"></div>
            <hr>
            <?php
            $count++;
        }
        ?>       
    </div>
    <!-- /.col-lg-12 -->                  
</div>