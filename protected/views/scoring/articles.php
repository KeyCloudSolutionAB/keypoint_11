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

        <div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'articles-form',
                'enableAjaxValidation' => false,
            ));
            ?>    
            <div class="table-responsive scorename_table_into">
                <table class="table table-striped table_checkbox">  
                    <?php foreach ($models as $k2 => $v2) { ?>
                        <?php
                        $store_category_id = $model->store_category_id;
                        $key = $scoring_model->id;
                        ?>
                        <?php if ($v2->getArtCatValue($store_category_id) !== NULL) { ?>                            
                            <tr>
                                <td>
                                    <label class="label_checkbox" for="checkbox<?php echo $key; ?><?php echo $k2; ?>">
                                        <?php echo $v2->article->title; ?>
                                        <br>
                                        <span class="lighter">
                                            <?php echo $v2->article->article_id; ?>, <?php echo $v2->article->cpg; ?>, (<?php echo $v2->getArtCatValue($store_category_id); ?>)
                                        </span>
                                    </label>   
                                </td>
                                <?php
                                $model_answer_article = AnswerArticle::model()->findByAttributes(array('total_scoring_id' => $model_total_scoring->id, 'article_point_id' => $v2->id));
                                ?>
                                <?php if ($v2->num == 0) { ?>
                                    <?php if (!empty($model_answer_article)) { ?>
                                        <?php
                                        $checked = 0;
                                        if ($model_answer_article->answer == 1) {
                                            $checked = 1;
                                        }
                                        ?>
                                        <td style="width: 100px;">  
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $model_total_scoring->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][article_id]" type="hidden" value="<?php echo $v2->id; ?>">                                            
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][answer]" type="checkbox" class="checkbox" id="checkbox<?php echo $key; ?><?php echo $k2; ?>" <?php echo empty($checked) ? '' : 'checked="checked"'; ?> >
                                            <label for="checkbox<?php echo $key; ?><?php echo $k2; ?>"></label>   
                                        </td>
                                    <?php } else { ?>
                                        <td style="width: 100px;">    
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $model_total_scoring->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][article_id]" type="hidden" value="<?php echo $v2->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][answer]" type="checkbox" class="checkbox" id="checkbox<?php echo $key; ?><?php echo $k2; ?>" >
                                            <label for="checkbox<?php echo $key; ?><?php echo $k2; ?>"></label>   
                                        </td>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if (!empty($model_answer_article)) {
                                        ?>
                                        <td style="width: 100px;"> 
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $model_total_scoring->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][article_id]" type="hidden" value="<?php echo $v2->id; ?>">                                           
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][answer_num]" type="number" class="form-control" value="<?php echo $model_answer_article->answer_num; ?>" placeholder="<?php echo Yii::t("translation", "please_add_a_number"); ?>" id="checkbox<?php echo $key; ?><?php echo $k2; ?>" >
                                        </td>
                                    <?php } else { ?>
                                        <td style="width: 100px;">  
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $model_total_scoring->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][article_id]" type="hidden" value="<?php echo $v2->id; ?>">                                            
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][answer_num]" type="number" class="form-control" value="" placeholder="<?php echo Yii::t("translation", "please_add_a_number"); ?>" id="checkbox<?php echo $key; ?><?php echo $k2; ?>" >
                                        </td>
                                    <?php } ?>
                                <?php } ?>
                            </tr>                                
                        <?php } ?>
                    <?php } ?>
                </table> 
            </div>


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