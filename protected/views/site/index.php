<div class="row">
    <div class="col-lg-12 margin_top_10">
        <div class="margin_bottom_10 text-center"> 

            <div class="btn-group" role="group">
                <?php echo CHtml::link(Yii::t("translation", "my_scoreing"), '#', array('class' => 'btn btn-myprimary')); ?>
                <?php echo CHtml::link(Yii::t("translation", "view_store_article"), array('/all_store/article'), array('class' => 'btn btn-default')); ?>
                <?php echo CHtml::link(Yii::t("translation", "recent_activety"), array('/recent_activety/index'), array('class' => 'btn btn-default')); ?> 
            </div>           
        </div>  

        <div class="list_score">
            <?php
            $num = 0;
            foreach ($my_all_scoreing as $key => $value) {
                $url = CHtml::normalizeUrl(array('my_scoreing/view', 'id' => $value->id));
                $url_missing_store = CHtml::normalizeUrl(array('my_scoreing/missing_store', 'id' => $value->id));
                $percent = $value->totalPercent();
                $criteria = new CDbCriteria;
                $criteria->condition = 'scoring_id = :scoringId AND percent > 0';
                $criteria->params = array(':scoringId' => $value->id);
                $criteria->select = 'id, percent';
                $total_scoring = TotalScoring::model()->findAll($criteria);
                //
                $possible_store = $value->PossibleStore;
                $missing_store = count($possible_store) - count($total_scoring);
                //
                $url_all_image = CHtml::normalizeUrl(array('my_scoreing/all_images', 'id' => $value->id));
                //
                $all_answer_uploads = $value->getAnswerUpload();
                $count_all_answer_uploads = count($all_answer_uploads);
                //
                ?>
                <div class="score_box">
                    <h3><?php echo CHtml::link($value->title, array('site/top', 'id' => $value->id), array('' => '')) ?></h3>
                    <div class="score_box_procent">
                        <div id="divProgress<?php echo $num; ?>"></div>
                        <script>
                            $(document).ready(function () {
                                $("#divProgress<?php echo $num; ?>").circularloader({
                                    radius: 50,
                                    progressPercent: <?php echo $percent; ?>,
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
                    <div class="list-group">
                        <a href="<?php echo $url; ?>" class="list-group-item"><div><span><?php echo count($possible_store); ?></span> <i class="fa fa-angle-right"></i></div> <?php echo Yii::t("translation", "possible_store"); ?></a>
                        <a href="<?php echo $url_missing_store; ?>" class="list-group-item"><div><span><?php echo $missing_store; ?></span> <i class="fa fa-angle-right"></i></div> <?php echo Yii::t("translation", "missing_store"); ?></a>
                        <a href="<?php echo $url_all_image; ?>" class="list-group-item"><div><span><?php echo $count_all_answer_uploads; ?></span> <i class="fa fa-angle-right"></i></div> <?php echo Yii::t("translation", "image"); ?></a>            
                    </div>              
                </div>             
                <?php
                $num++;
            }
            ?>
        </div>
    </div>
    <!-- /.col-lg-12 -->                   
</div>