<?php if (Yii::app()->user->hasFlash('error')) { ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>     
    </div>
<?php } ?>
<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "share_dashboard"); ?></h1>
    </div>   
</div>

<div class="row">
    <div class="col-lg-6">


        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "average_measuring"); ?>
                <div class="btn-group btn-group-sm messured_box" role="group" aria-label="">                   
                    <?php
                    if ($everage_mesured_store) {
                        echo CHtml::link(Yii::t("translation", "all"), array('dashboard_share/index', 'key_id' => $model->key, 'everage_active' => 'yes'), array('class' => 'btn btn-myprimary'));
                        echo CHtml::link(Yii::t("translation", "messured"), array('dashboard_share/index', 'key_id' => $model->key, 'everage_active' => 'no'), array('class' => 'btn btn-default'));
                    } else {

                        echo CHtml::link(Yii::t("translation", "all"), array('dashboard_share/index', 'key_id' => $model->key, 'everage_active' => 'yes'), array('class' => 'btn btn-default'));
                        echo CHtml::link(Yii::t("translation", "messured"), array('dashboard_share/index', 'key_id' => $model->key, 'everage_active' => 'no'), array('class' => 'btn btn-myprimary'));
                    }
                    ?>  
                </div>  

            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="list_score">
                        <?php
                        foreach ($models as $key => $value) {
                            if ($everage_mesured_store) {
                                $percent = $value->Percent;
                            } else {
                                $percent = $value->PercentMiss;
                            }
                            $possible_store = count($value->PossibleStore2);
                            $missing_store = $value->MissingStore;
                            $image = count($value->ImageStore);
                            $url_possible_store = CHtml::normalizeUrl(array('dashboard_share/possible', 'id' => $value->id, 'key_id' => $model->key));
                            $url_mesured_store = CHtml::normalizeUrl(array('dashboard_share/possible', 'id' => $value->id, 'key_id' => $model->key, 'mesured' => 'true'));
                            $url_missing_store = CHtml::normalizeUrl(array('dashboard_share/missing', 'id' => $value->id, 'key_id' => $model->key));
                            $url_image = CHtml::normalizeUrl(array('dashboard_share/image', 'id' => $value->id, 'key_id' => $model->key));
                            ?>
                            <div class="score_box">
                                <h3><?php echo CHtml::link($value->title, array('dashboard_share/top', 'id' => $value->id, 'key_id' => $model->key), array('' => '')) ?></h3>
                                <div class="score_box_procent">
                                    <div id="divProgress<?php echo $key; ?>"></div>
                                    <script>
                                        $(document).ready(function () {
                                            $("#divProgress<?php echo $key; ?>").circularloader({
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
                                    <?php if ($everage_mesured_store) { ?>
                                        <a href="<?php echo $url_possible_store; ?>" class="list-group-item"><div><span><?php echo $possible_store; ?></span> <i class="fa fa-angle-right"></i></div> <?php echo Yii::t("translation", "possible_store"); ?></a>
                                    <?php } else { ?>
                                        <a href="<?php echo $url_mesured_store; ?>" class="list-group-item"><div><span><?php echo $possible_store - $missing_store; ?></span> <i class="fa fa-angle-right"></i></div> <?php echo Yii::t("translation", "measured_store"); ?></a>
                                    <?php } ?>                                    
                                    <a href="<?php echo $url_missing_store; ?>" class="list-group-item"><div><span><?php echo $missing_store; ?></span> <i class="fa fa-angle-right"></i></div> <?php echo Yii::t("translation", "missing_store"); ?></a>
                                    <a href="<?php echo $url_image; ?>" class="list-group-item"><div><span><?php echo $image; ?></span> <i class="fa fa-angle-right"></i></div> <?php echo Yii::t("translation", "images"); ?>    </a>            
                                </div>              
                            </div>      
                        <?php } ?>                          
                    </div>                
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default table_margin_0 recent_activities">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "recent_activety"); ?>
            </div>           
            <div class="panel-body">
                <div class="col-lg-12">
                    <?php
                    foreach ($total_scorings as $key => $value) {
                        break;
                        $url = "#";
                        ?>
                        <div class="my_scoreing_box">
                            <p>
                                <strong><?php echo $value->user->name; ?></strong>
                                <span class="pull-right text-muted"><?php echo $value->percent; ?>%</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $value->percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $value->percent; ?>%">
                                    <span class="sr-only"><?php echo $value->percent; ?>%</span>
                                </div>
                            </div>

                            <div class="table-responsive table-bordered">
                                <table class="table">                                                       
                                    <tbody>
                                        <?php
                                        $image = $value->lastUploadImage();
                                        if (!empty($image)) {
                                            ?>
                                            <tr>
                                                <td><?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $image->image, $image->image, array('style' => 'width: 200px;')); ?></td>                                                                                                         
                                            </tr> 
                                        <?php } ?>
                                        <tr>
                                            <td>
                                                <?php
                                                $model_store = Store::model()->resetScope()->findByPk($value->store_id);
                                                echo $model_store->storename;
                                                ?></td>                                                                                                         
                                        </tr>   
                                        <?php
                                        $note = AnswerNote::model()->resetScope()->findByAttributes(array('total_scoring_id' => $value->id));
                                        if (!empty($note)) {
                                            ?>
                                            <tr>
                                                <td>Note: <?php echo $note->note; ?></td>                                                                                                        
                                            </tr> 
                                        <?php } ?>

                                        <?php if (!empty($value->date_update)) { ?>
                                            <tr>
                                                <td><?php echo date("d/m/Y H:i", strtotime($value->date_update)); ?></td>                                                                                                     
                                            </tr> 
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>  

                    <div class="table-responsive border_null">
                        <table class="table">                                                   
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($total_scorings as $key => $value) {
                                    $url = "#";
                                    ?>
                                    <tr>
                                        <td  style="width: 105px;">
                                            <div class="score_box_procent recent_activety_box">
                                                <div id="divProgress_<?php echo $count; ?>"></div>
                                                <script>
                                                    $(document).ready(function () {
                                                        $("#divProgress_<?php echo $count; ?>").circularloader({
                                                            radius: 40,
                                                            progressPercent: <?php echo $value->percent; ?>,
                                                            backgroundColor: "#fff",
                                                            fontColor: "#18a657",
                                                            fontSize: "16px",
                                                            progressBarBackground: "#3d81da",
                                                            progressBarColor: "#18a657",
                                                            progressBarWidth: 6,
                                                            showText: true,
                                                        });
                                                    });
                                                </script>
                                            </div> 
                                        </td>
                                        <td>
                                            <b><?php echo $value->user->name; ?></b><br>
                                            <?php
                                            $model_store = Store::model()->resetScope()->findByPk($value->store_id);
                                            echo $model_store->storename;
                                            echo '<br>';
                                            //
                                            $note = AnswerNote::model()->resetScope()->findByAttributes(array('total_scoring_id' => $value->id));
                                            if (!empty($note)) {
                                                echo 'Note: ';
                                                echo $note->note;
                                                echo '<br>';
                                            }
                                            ?>

                                            <div class="time"><?php echo date("d/m/Y H:i", strtotime($value->date_update)); ?></div>
                                        </td>
                                        <?php
                                        $image = $value->lastUploadImage();
                                        if (!empty($image)) {
                                            ?>
                                            <td><?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $image->image, $image->image, array('style' => 'width: 100px;')); ?></td>                                                                                                         
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                                ?>  
                            </tbody>
                        </table>
                    </div> 
                </div>  
            </div>  
        </div>       
    </div>  
</div>
