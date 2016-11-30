<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/clipboard.min.js"></script>
<script>
    $(document).ready(function () {
        var clipboard = new Clipboard('.btn');
        clipboard.on('success', function (e) {
            alert("<?php echo Yii::t("translation", "you_have_successfully_copied"); ?>");
        });
    });


</script>

<?php
$this->breadcrumbs = array(Yii::t("translation", "dashboards"));
?>


<?php if (Yii::app()->user->hasFlash('error')) { ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>     
    </div>
<?php } ?>

<div class="alert alert-info display_none" id="dashboard_add">

</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "dashboards"); ?></h1>
    </div>   
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">                          
            <div class="panel-body">   
                <div class="col-sm-8">   
                    <?php
                    if ($active) {
                        if ($everage_mesured_store) {
                            echo CHtml::link('<i class="fa fa-check-square-o"></i> ' . Yii::t("translation", "show_active_scoring"), array('default/index', 'active' => 'no', 'everage_active' => 'yes'), array('class' => 'btn btn-default'));
                        } else {
                            echo CHtml::link('<i class="fa fa-check-square-o"></i> ' . Yii::t("translation", "show_active_scoring"), array('default/index', 'active' => 'no', 'everage_active' => 'no'), array('class' => 'btn btn-default'));
                        }
                    } else {
                        if ($everage_mesured_store) {
                            echo CHtml::link('<i class="fa fa-square-o"></i> ' . Yii::t("translation", "show_active_scoring"), array('default/index', 'active' => 'yes', 'everage_active' => 'yes'), array('class' => 'btn btn-default'));
                        } else {
                            echo CHtml::link('<i class="fa fa-square-o"></i> ' . Yii::t("translation", "show_active_scoring"), array('default/index', 'active' => 'yes', 'everage_active' => 'no'), array('class' => 'btn btn-default'));
                        }
                    }
                    ?>                  
                    <?php echo CHtml::link('<i class="fa fa-filter"></i>', array('default/filters'), array('class' => 'btn btn-default')); ?> 
                    <?php echo CHtml::link('<i class="fa fa-list-ol"></i>', array('default/top'), array('class' => 'btn btn-default')); ?>                   
                </div>
                <div class="col-sm-4 text-right">                                                                   
                    <?php
                    if (!empty($dashboard_links)) {
                        echo CHtml::ajaxLink(
                                '<i class="fa fa-share-alt"></i> <span class="badge">' . count($dashboard_links) . '</span>', CController::createUrl('dashboard/add'), array(
                            'type' => 'POST', // method
                            'data' => array('update' => TRUE), // DATA
                            'update' => '#dashboard_add',
                            'complete' => 'function() {
                            $("#dashboard_add").removeClass("display_none");
                          }',
                                ), array('class' => 'btn btn-success', 'id' => 'share_button_link'));
                    } else {
                        echo CHtml::ajaxLink(
                                '<i class="fa fa-share-alt"></i>', CController::createUrl('dashboard/add'), array(
                            'type' => 'POST', // method
                            'data' => array('update' => TRUE), // DATA
                            'update' => '#dashboard_add',
                            'complete' => 'function() {
                            $("#dashboard_add").removeClass("display_none");
                            $("#share_button_link").removeClass("btn-default");
                            $("#share_button_link").addClass("btn-success");
                          }',
                                ), array('class' => 'btn btn-default', 'id' => 'share_button_link'));
                    }
                    ?>

                    <?php
                    if (!empty($dashboard_links)) {
                        echo CHtml::link('<i class="fa fa-times"></i>', array('default/index', 'delete_share_link' => 'ok'), array('class' => 'btn btn-default'));
                    }
                    ?>

                </div>
            </div>                            
        </div>  

        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "average_measuring"); ?>

                <div class="btn-group btn-group-sm messured_box" role="group" aria-label="">                   
                    <?php
                    if ($active) {
                        if ($everage_mesured_store) {

                            echo CHtml::link(Yii::t("translation", "all"), array('default/index', 'everage_active' => 'yes', 'active' => 'yes'), array('class' => 'btn btn-myprimary'));
                            echo CHtml::link(Yii::t("translation", "messured"), array('default/index', 'everage_active' => 'no', 'active' => 'yes'), array('class' => 'btn btn-default'));
                        } else {

                            echo CHtml::link(Yii::t("translation", "all"), array('default/index', 'everage_active' => 'yes', 'active' => 'yes'), array('class' => 'btn btn-default'));
                            echo CHtml::link(Yii::t("translation", "messured"), array('default/index', 'everage_active' => 'no', 'active' => 'yes'), array('class' => 'btn btn-myprimary'));
                        }
                    } else {
                        if ($everage_mesured_store) {

                            echo CHtml::link(Yii::t("translation", "all"), array('default/index', 'everage_active' => 'yes', 'active' => 'no'), array('class' => 'btn btn-myprimary'));
                            echo CHtml::link(Yii::t("translation", "messured"), array('default/index', 'everage_active' => 'no', 'active' => 'no'), array('class' => 'btn btn-default'));
                        } else {

                            echo CHtml::link(Yii::t("translation", "all"), array('default/index', 'everage_active' => 'yes', 'active' => 'no'), array('class' => 'btn btn-default'));
                            echo CHtml::link(Yii::t("translation", "messured"), array('default/index', 'everage_active' => 'no', 'active' => 'no'), array('class' => 'btn btn-myprimary'));
                        }
                    }
                    ?>  
                </div>  
                <div class="btn-group float_right">
                    <?php echo CHtml::link('<i class="fa fa-list"></i>', array('scoring/index'), array('class' => 'btn btn-default')); ?> 
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
                            $possible_store = count($value->PossibleStore);
                            $missing_store = $value->MissingStore;
                            $image = count($value->ImageStore);
                            $url_possible_store = CHtml::normalizeUrl(array('default/view', 'id' => $value->id));
                            $url_mesured_store = CHtml::normalizeUrl(array('default/view', 'id' => $value->id, 'mesured' => 'true'));
                            $url_missing_store = CHtml::normalizeUrl(array('default/missing', 'id' => $value->id));
                            $url_image = CHtml::normalizeUrl(array('default/image', 'id' => $value->id));
                            ?>
                            <div class="score_box">
                                <h3><?php echo CHtml::link($value->title, array('default/top', 'id' => $value->id), array('' => '')) ?> <?php echo CHtml::link('<i class="fa fa-pencil-square-o"></i>', array('scoring/update', 'id' => $value->id), array('class' => '')) ?></h3>
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
        <?php $this->renderPartial('_search_form'); ?>             
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
                                            echo $value->NameScoring;
                                            echo '<br>';
                                            //
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
                                            <td>
                                                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $image->image, $image->image, array('style' => 'width: 100px;')); ?>
                                                <?php if ($value->LastPercent > 0) { ?>
                                                    <span class="last_percent label label-success"><?php echo $value->LastPercent; ?></span>
                                                <?php } else { ?>
                                                    <span class="last_percent label label-danger"><?php echo $value->LastPercent; ?></span>
                                                <?php } ?>
                                            </td>                                                                                                         
                                        <?php } else { ?>
                                            <td>
                                                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/no-thumb.png', 'No image', array('style' => 'width: 100px;', 'class' => 'img-thumbnail')); ?>
                                                <?php if ($value->LastPercent > 0) { ?>
                                                    <span class="last_percent label label-success"><?php echo $value->LastPercent; ?></span>
                                                <?php } else { ?>
                                                    <span class="last_percent label label-danger"><?php echo $value->LastPercent; ?></span>
                                                <?php } ?>
                                            </td>   
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
