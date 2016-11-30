<?php
$this->breadcrumbs = array(
    Yii::t("translation", "dashboards") => array('index'),
    Yii::t("translation", "list"),
);
?>


<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "dashboards"); ?></h1>
    </div>   
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">                          
            <div class="panel-body">
                <?php
                if (!empty($model)) {
                    echo CHtml::link('<i class="fa fa-arrow-left"></i>', array('site/index'), array('class' => 'btn btn-default'));
                } else {
                    echo CHtml::link('<i class="fa fa-arrow-left"></i>', array('site/index'), array('class' => 'btn btn-default'));
                }
                ?>  
            </div>                            
        </div>                       
        <div class="panel panel-default">
            <div class="panel-heading">
                List
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <ul class="list-unstyled">
                    <?php
                    $color_count = 0;
                    foreach ($models as $key => $value) {
                        $model = User::model()->resetScope()->findByPk($value['user_id']);
                        $all_sum = $value['sum_percent'];
//                         $all_sum = TotalScoring::model()->getTotalSumSeller($model->id, $value->id);
                        $array = array(
                            '0' => '',
                            '1' => 'progress-bar-success',
                            '2' => 'progress-bar-info',
                            '3' => 'progress-bar-warning',
                            '4' => 'progress-bar-danger',
                        );                       
                        if ($color_count == 5) {
                            $color_count = 0;
                        }
                        $color = $array[$color_count];
                        $color_count++;
                        ?>
                        <?php if ($key == 0) { ?>
                            <li>
                                <div>
                                    <p>
                                        <strong><?php echo $model->name; ?></strong>
                                        <span class="pull-right text-muted"><?php echo $all_sum; ?>%</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div style="width: <?php echo $all_sum; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $all_sum; ?>" role="progressbar" class="progress-bar <?php echo $color; ?>">
                                            <span class="sr-only"><?php echo $all_sum; ?>%</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="divider"></li>
                            <li>

                                <div>
                                    <p>
                                        <strong><?php echo $model->name; ?></strong>
                                        <span class="pull-right text-muted"><?php echo $all_sum; ?>%</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div style="width: <?php echo $all_sum; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $all_sum; ?>" role="progressbar" class="progress-bar <?php echo $color; ?>">
                                            <span class="sr-only"><?php echo $all_sum; ?>%</span>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        <?php } ?>
                    <?php } ?>                  
                </ul>
            </div>        
        </div>      
    </div>   
</div>