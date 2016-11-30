<div class="row">
    <div class="col-lg-12 margin_top_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>
        <div class="margin_bottom_10">    
            <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('site/index'), array('class' => 'btn btn-default')); ?>           
        </div>            

        <div class="table-responsive scorename_table">           
            <table class="table table-striped table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th>
                            <?php echo Yii::t("translation", "my_all_store"); ?>
                        </th>  
                    </tr>
                    <tr class="filters">
                        <td>
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'method' => 'GET',
                                'action' => CHtml::normalizeUrl(array('all_store/article')),
                            ));

                            if (isset($_GET['q'])) {
                                $q = CHtml::encode($_GET['q']);
                            }
                            ?>
                            <div class="form-group input-group">
                                <?php if (!empty($q)) { ?>
                                    <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="q">
                                <?php } ?>

                                <span class="input-group-btn">
                                    <button name="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <?php $this->endWidget(); ?>
                        </td>  
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($all_stores)) {
                        foreach ($all_stores as $key => $value) {                          
                            $percents = TotalScoring::model()->findAllByAttributes(array('store_id' => $value['id']));
                            $percent = 0;
                            if (!empty($percents)) {
                                $count = count($percents);
                                $total_percent = 0;
                                foreach ($percents as $ke => $va) {
                                    $total_percent = $va->percent + $total_percent;
                                }
                                $percent = $total_percent / $count;
                                $percent = floor($percent);                               
                            }


                            $store_url = CHtml::normalizeUrl(array('all_store/articles', 'id_store' => $value['id']));
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
                                                            progressPercent: <?php echo $percent; ?>,
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