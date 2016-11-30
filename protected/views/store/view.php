<div class="row">  
    <div class="col-lg-12 margin_top_10 margin_bottom_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('my_scoreing/view', 'id' => $scoring_model->id), array('class' => 'btn btn-default')); ?>

        <h3><?php echo $scoring_model->title; ?> <span class="pull-right text-muted">
                <span class="vertical-align-middle">
                    <?php echo $model_total_scoring->percent; ?>%
                </span>
                <?php if ($model_total_scoring->LastPercent > 0) { ?>
                    <span class="store_last_percent label label-success"><?php echo $model_total_scoring->LastPercent; ?>%</span>
                <?php } else { ?>
                    <span class="store_last_percent label label-danger"><?php echo $model_total_scoring->LastPercent; ?>%</span>
                <?php } ?>
            </span>
        </h3>
        <div class="progress progress-striped active">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $model_total_scoring->percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $model_total_scoring->percent; ?>%">
                <?php // echo $model_total_scoring->LastPercent; ?>
            </div>
        </div>   

        <?php $this->widget('application.extensions.MenuForms.MenuForms', array('model' => $model, 'scoring_model' => $scoring_model)); ?>      

        <div id="user-grid" class="scorename_table_into">   
            <p><?php echo Yii::t("translation", "choice"); ?>:</p>           
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'enableAjaxValidation' => false,
            ));
            ?>         
            <table class="table table-striped table-bordered table_checkbox">                              
                <tbody> 
                    <?php
                    $n = 0;
                    foreach ($models as $key => $value) {
                        $checked = FALSE;
                        if (!empty($array_all_answers)) {
                            $bool = array_key_exists($value->id, $array_all_answers);
                            if ($bool) {
                                $value_id = $value['id'];
                                if (!empty($array_all_answers[$value_id]['answer'])) {
                                    if ($array_all_answers[$value_id]['answer'] == 1) {
                                        $checked = TRUE;
                                    }
                                }
                            }
                        }


                        $n++;
                        ?>
                        <tr>
                            <td>
                                <?php if ($value->num == 1) { ?>
                                    <?php if (isset($value_id)) { ?>                                        
                                        <label for="Choice[<?php echo $value->id; ?>]"><?php echo $value->description; ?></label> 
                                        <input placeholder="<?php echo Yii::t("translation", "please_add_a_number"); ?>" type="number" class="form-control" value="<?php echo $array_all_answers[$value_id]['answer_num']; ?>" name="Choice[<?php echo $value->id; ?>]">
                                    <?php } else { ?>                                        
                                        <label for="Choice[<?php echo $value->id; ?>]"><?php echo $value->description; ?></label>  
                                        <input placeholder="<?php echo Yii::t("translation", "please_add_a_number"); ?>" type="number" class="form-control" value="" name="Choice[<?php echo $value->id; ?>]">
                                    <?php } ?>

                                <?php } else { ?>
                                    <input type="checkbox" class="checkbox" name="Choice[<?php echo $value->id; ?>]" id="checkbox<?php echo $n; ?>" <?php echo empty($checked) ? '' : 'checked="checked"'; ?> >
                                    <label for="checkbox<?php echo $n; ?>"><?php echo $value->description; ?></label>                                  
                                <?php } ?> 
                            </td> 
                        </tr>
                    <?php } ?>                   

                </tbody>
            </table>           
            <button name="save" class="btn btn-default btn-block"><i class="fa fa-save"></i> <?php echo Yii::t("translation", "save"); ?></button>                

            <?php $this->endWidget(); ?>
        </div>   

    </div>
    <!-- /.col-lg-12 -->                   
</div>

<style type="text/css">
    .nmpd-grid {border: none; padding: 20px;}
    .nmpd-grid>tbody>tr>td {border: none;}

    /* Some custom styling for Bootstrap */
    .qtyInput {display: block;
               width: 100%;
               padding: 6px 12px;
               color: #555;
               background-color: white;
               border: 1px solid #ccc;
               border-radius: 4px;
               -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
               box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
               -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
               -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
               transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $('[type = number]').numpad();
    });
</script>