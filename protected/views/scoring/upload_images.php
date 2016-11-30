<style>
    input[type='file']{      
        height: 40px;        
    }
</style>

<div id="lodaing" class="lodaing" style="display: none;">
    <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/lodaing.svg">
</div>

<div class="row">
    <div class="col-lg-12 margin_top_10 margin_bottom_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('store/view', 'id' => $store_model->id, 'scoring' => $scoring_model->id), array('class' => 'btn btn-default')); ?>

        <h3><?php echo $scoring_model->title; ?>:  <?php echo Yii::t("translation", "add_image"); ?></h3>

        <?php $this->widget('application.extensions.MenuForms.MenuForms', array('model' => $store_model, 'scoring_model' => $scoring_model)); ?> 

        <?php // echo CHtml::link('<i class="fa fa-image"></i> <span class="badge">' . count($scoring_model->Images) . '</span>', array('scoring/image', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>
        <?php // echo CHtml::link('<i class="fa fa-sticky-note-o"></i>', array('scoring/note', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>
        <?php // echo CHtml::link('<i class="fa fa-camera"></i> <span class="badge">' . count($scoring_model->UploadImages) . '</span>', array('scoring/upload_images', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>

        <?php
        if (!empty($models)) {
            echo '<ul class="list-unstyled scorename_image_box">';
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'answer-upload-form',
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                    'name' => 'answer-upload-form',
            )));

            foreach ($models as $key => $value) {
                $model = AnswerUpload::model()->findByAttributes(array('total_scoring_id' => $model_total_scoring->id, 'scoring_image_upload_id' => $value->id));
                if (!empty($model)) {
                    echo '<p>';
                    echo $value->description;
                    echo '</p>';
                    echo '<p>';
                    echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $model->image, $value->description, array('class' => 'img-thumbnail')), Yii::app()->request->baseUrl . '/upload_files/answer_upload/' . $model->image);
                    echo '</p>';
                    echo '<p>';
                    echo CHtml::link('<i class="fa fa-trash-o"></i>', array('scoring/upload_images', 'id' => $scoring_model->id, 'store' => $store_model->id, 'delete' => $model->id), array('class' => 'btn btn-default margin_bottom_10'));
                    echo '</p>';
                } else {
                    echo '<li>';

                    echo '<div class="form-group">';
                    echo '<label>' . $value->description . '</label>';
                    echo CHtml::fileField('AnswerUpload' . $value->id . '[image]');
                    echo '</div>';

//                    echo CHtml::submitButton(Yii::t("translation", "add"), array('class' => 'btn btn-default', 'name' => 'add', 'id' => 'submit_button'));

                    echo '</li>';
                }
            }
            $this->endWidget();
            echo '</ul>';
        }
        ?>        
    </div>
    <!-- /.col-lg-12 -->                   
</div>

<script>
    $(document).ready(function () {
        $("input[type='file']").change(function () {
            $("#lodaing").show();
            this.form.submit();
        });
    });
</script>
