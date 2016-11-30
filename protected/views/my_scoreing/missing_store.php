<div class="row">
    <div class="col-lg-12 margin_top_10">
        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('/my_scoreing'), array('class' => 'btn btn-default')); ?>
        <h3><?php echo $model->title; ?>: <?php echo Yii::t("translation", "missing_store"); ?></h3>
        <?php
        if (!empty($model->note)) {
            echo '<p>';
            echo $model->note;
            echo '</p>';
        }
        ?>    

        <div class="table-responsive scorename_table">           
            <table class="table table-striped table-hover dataTable no-footer">

                <tbody>
                    <?php
                    $all_stores = $model->MissingStores;
                    if (!empty($all_stores)) {
                        foreach ($all_stores as $key => $value) {
                            $percent = TotalScoring::model()->findByAttributes(array('store_id' => $value->id, 'scoring_id' => $model->id));
                            $store_url = CHtml::normalizeUrl(array('store/view', 'id' => $value->id, 'scoring' => $model->id));
                            ?> 

                            <tr>
                                <td>              
                                    <a href="<?php echo $store_url; ?>" class="text_decoration_none">
                                        <div class="storename_table_title">
                                            <i class="fa fa-flag"></i>
                                            <?php echo $value['storename']; ?>
                                            <div><i class="fa fa-map-marker"></i> <?php echo $value['adress']; ?></div> 
                                        </div>

                                        <div class="storename_table_link text-right">

                                            <i class="fa fa-angle-right fa-4x"></i>
                                            <span>
                                                <div id="divProgress<?php echo $key; ?>"></div>                                               
                                                <script>
                                                    $(document).ready(function () {
                                                        $("#divProgress<?php echo $key; ?>").circularloader({
                                                            radius: 22,
                                                            progressPercent: <?php echo empty($percent) ? "0" : $percent->percent; ?>,
                                                            backgroundColor: "#ffffff",
                                                            fontColor: "#18a657",
                                                            fontSize: "12px",
                                                            progressBarBackground: "#3d81da",
                                                            progressBarColor: "#18a657",
                                                            progressBarWidth: 6,
                                                            showText: true,
                                                        });
                                                    });
                                                </script>


                                            </span> 


                                        </div>
                                    </a> 
                                </td> 
                            </tr>
                            <?php
                        }
                    }
                    ?>                   
                </tbody>
            </table>           
        </div>   

    </div>
    <!-- /.col-lg-12 -->                   
</div>