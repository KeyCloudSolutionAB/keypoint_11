<div class="row">
    <div class="col-lg-12 margin_top_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>
        <div class="margin_bottom_10">    
            <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('all_store/article'), array('class' => 'btn btn-default')); ?>
        </div>   
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'articles-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <?php echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?><br><br>
        <?php foreach ($array as $key => $value) { ?>
            <?php
            $model_scoring = Scoring::model()->findByPk($key);
            $total_acoring_model = TotalScoring::model()->findByAttributes(array('scoring_id' => $model_scoring->id, 'store_id' => $store_id, 'user_id' => Yii::app()->user->id));
            ?>
            <b><?php echo $model_scoring->title; ?></b>           
            <div class="table-responsive scorename_table_into">
                <table class="table table-striped table_checkbox">  
                    <?php foreach ($value as $k2 => $v2) { ?>
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
                                $model_answer_article = AnswerArticle::model()->findByAttributes(array('total_scoring_id' => $total_acoring_model->id, 'article_point_id' => $v2->id));
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
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $total_acoring_model->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][article_id]" type="hidden" value="<?php echo $v2->id; ?>">                                            
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][answer]" type="checkbox" class="checkbox" id="checkbox<?php echo $key; ?><?php echo $k2; ?>" <?php echo empty($checked) ? '' : 'checked="checked"'; ?> >
                                            <label for="checkbox<?php echo $key; ?><?php echo $k2; ?>"></label>   
                                        </td>
                                    <?php } else { ?>
                                        <td style="width: 100px;">    
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $total_acoring_model->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][article_id]" type="hidden" value="<?php echo $v2->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][answer]" type="checkbox" class="checkbox" id="checkbox<?php echo $key; ?><?php echo $k2; ?>" >
                                            <label for="checkbox<?php echo $key; ?><?php echo $k2; ?>"></label>   
                                        </td>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if (!empty($model_answer_article)) {
                                        ?>
                                        <td style="width: 100px;"> 
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $total_acoring_model->id; ?>">
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][article_id]" type="hidden" value="<?php echo $v2->id; ?>">                                           
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][answer_num]" type="number" class="form-control" value="<?php echo $model_answer_article->answer_num; ?>" placeholder="<?php echo Yii::t("translation", "please_add_a_number"); ?>" id="checkbox<?php echo $key; ?><?php echo $k2; ?>" >
                                        </td>
                                    <?php } else { ?>
                                        <td style="width: 100px;">  
                                            <input name="Answer[<?php echo $key; ?>][<?php echo $k2; ?>][total_scoring_id]" type="hidden" value="<?php echo $total_acoring_model->id; ?>">
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
        <?php } ?>

        <?php echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>

        <?php $this->endWidget(); ?>
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