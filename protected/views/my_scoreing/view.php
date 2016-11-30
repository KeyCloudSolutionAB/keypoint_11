<div class="row">
    <div class="col-lg-12 margin_top_10">
        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('/my_scoreing'), array('class' => 'btn btn-default')); ?>
        <h3><?php echo $model->title; ?></h3>
        <?php
        if (!empty($model->note)) {
            echo '<p>';
            echo $model->note;
            echo '</p>';
        }
        ?>    


        <div class="table-responsive scorename_table">           
            <table class="table table-striped table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th>
                            <?php echo Yii::t("translation", "store_name"); ?>
                        </th>  
                    </tr>
                    <tr class="filters">
                        <td>
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'method' => 'GET',
                                'action' => CHtml::normalizeUrl(array('my_scoreing/view', 'id' => $model->id)),
                            ));
                            ?>
                            <div class="form-group input-group">
                                <input type="text" class="form-control" name="q">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <?php $this->endWidget(); ?>
                        </td>  
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['q'])) {
                        $q = CHtml::encode($_GET['q']);
                        if (!empty($q)) {
                            $all_stores = $model->getPossibleStore($q);
                        } else {
                            $all_stores = $model->PossibleStore;
                        }
                    } else {
                        $all_stores = $model->PossibleStore;
                    }

                    if (!empty($all_stores)) {
                        foreach ($all_stores as $key => $value) {
                            $percent = TotalScoring::model()->findByAttributes(array('store_id' => $value['id'], 'scoring_id' => $model->id));
                            $store_url = CHtml::normalizeUrl(array('store/view', 'id' => $value['id'], 'scoring' => $model->id));
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