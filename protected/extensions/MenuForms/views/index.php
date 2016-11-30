<div class="btn-group" role="group">
    <?php
    $models_art = ArticlePoint::model()->findAllByAttributes(array('scoring_id' => $scoring_model->id));
    if (!empty($models_art)) {
        echo CHtml::link(Yii::t("translation", "articles"), array('scoring/articles', 'id' => $scoring_model->id, 'store' => $model->id), array('class' => 'btn btn-default margin_bottom_10'));
    }
    ?>   

    <?php
    $models = ScoringDescription::model()->findAllByAttributes(array('scoring_id' => $scoring_model->id));
    if (!empty($models)) {
        echo CHtml::link(Yii::t("translation", "forms"), array('store/view', 'id' => $model->id, 'scoring' => $scoring_model->id), array('class' => 'btn btn-default margin_bottom_10'));
    }
    ?> 

    <?php
    if (count($scoring_model->UploadImages) != 0) {
        echo CHtml::link(Yii::t("translation", "slider") . ' <span class="badge">' . count($scoring_model->UploadImages) . '</span>', array('scoring/upload_images', 'id' => $scoring_model->id, 'store' => $model->id), array('class' => 'btn btn-default margin_bottom_10'));
    }
    ?>

    <?php
    if (count($scoring_model->Images) != 0) {
        echo CHtml::link(Yii::t("translation", "images") . ' <span class="badge">' . count($scoring_model->Images) . '</span>', array('scoring/image', 'id' => $scoring_model->id, 'store' => $model->id), array('class' => 'btn btn-default margin_bottom_10'));
    }
    ?> 

</div>
<?php echo CHtml::link('<i class="fa fa-sticky-note-o"></i>', array('scoring/note', 'id' => $scoring_model->id, 'store' => $model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>
