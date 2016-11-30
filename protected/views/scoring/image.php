<script>
    $(document).ready(function () {
        $('.carousel').carousel({
            interval: false
        })
    });
</script>

<div class="row">  
    <div class="col-lg-12 margin_top_10 margin_bottom_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('store/view', 'id' => $store_model->id, 'scoring' => $scoring_model->id), array('class' => 'btn btn-default')); ?>

        <h3><?php echo $scoring_model->title; ?>:  <?php echo Yii::t("translation", "images"); ?></h3>

        <?php $this->widget('application.extensions.MenuForms.MenuForms', array('model' => $store_model, 'scoring_model' => $scoring_model)); ?>  

        <?php // echo CHtml::link('<i class="fa fa-image"></i> <span class="badge">' . count($scoring_model->Images) . '</span>', array('scoring/image', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>
        <?php // echo CHtml::link('<i class="fa fa-sticky-note-o"></i>', array('scoring/note', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>
        <?php // echo CHtml::link('<i class="fa fa-camera"></i> <span class="badge">' . count($scoring_model->UploadImages) . '</span>', array('scoring/upload_images', 'id' => $scoring_model->id, 'store' => $store_model->id), array('class' => 'btn btn-default margin_bottom_10')); ?>

        <?php if (!empty($models)) { ?>
            <div id="carousel-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php
                    foreach ($models as $key => $value) {
                        if ($key == 0) {
                            echo '<li data-target="#carousel-generic" data-slide-to="0" class="active"></li>';
                        } else {
                            echo '<li data-target="#carousel-generic" data-slide-to="' . $key . '"></li>';
                        }
                    }
                    ?>                 
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php
                    foreach ($models as $key => $value) {
                        if ($key == 0) {
                            echo '<div class="item active">';
                            echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/upload_files/scoring_image/' . $value->image, empty($value->title) ? "" : $value->title), Yii::app()->request->baseUrl . '/upload_files/scoring_image/' . $value->image);
                            echo '</div>';
                        } else {
                            echo '<div class="item">';
                            echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/upload_files/scoring_image/' . $value->image, empty($value->title) ? "" : $value->title), Yii::app()->request->baseUrl . '/upload_files/scoring_image/' . $value->image);
                            echo '</div>';
                        }
                    }
                    ?>              
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo Yii::t("translation", "previous"); ?></span>
                </a>
                <a class="right carousel-control" href="#carousel-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo Yii::t("translation", "next"); ?></span>
                </a>
            </div>  
        <?php } ?>
    </div>
    <!-- /.col-lg-12 -->                   
</div>