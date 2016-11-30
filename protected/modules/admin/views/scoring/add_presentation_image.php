<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "add_presentation_image"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i> ' . Yii::t("translation", "back"), 'url' => array('add_team', 'id' => $model->id), 'encodeLabel' => FALSE),
);

$this->menu_right = array(
    array('label' => Yii::t("translation", "next") . ' <i class="fa fa-arrow-right"></i>', 'url' => array('add_description', 'id' => $model->id), 'encodeLabel' => FALSE),
);
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add_presentation_image"); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">    
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <?php if (Yii::app()->user->hasFlash('error')) { ?>
            <div class="alert alert-danger">
                <?php echo Yii::app()->user->getFlash('error'); ?>     
            </div>
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "add_team"); ?>
            </div>           
            <div class="panel-body"> 
                <div class="col-lg-8">  
                    <?php $this->renderPartial('_form_upload_image', array('model' => $model_scoring_image)); ?>

                    <ul class="list-unstyled choice">
                        <?php foreach ($models as $key => $value) { ?>                            
                            <li id="position_<?php echo $value->id; ?>">      
                                <span class="btn btn-default handle"><i class="fa fa-list"></i></span>   
                                <img alt="" class="img-thumbnail" src="<?php echo Yii::app()->request->baseUrl; ?>/upload_files/scoring_image/<?php echo $value->image; ?>">
                                <button id="<?php echo $value->id; ?>" class="btn btn-default del_description"><i class="fa fa-trash"></i></button>
                            </li>
                        <?php } ?>
                    </ul>
                </div>                 
            </div>           
        </div>
    </div>
</div>
<?php $url_delete = CHtml::normalizeUrl(array('scoring/delete_image', 'id' => $model->id)); ?>
<?php $url_position = CHtml::normalizeUrl(array('scoring/change_position', 'id' => $model->id)); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
<script>
    $(document).ready(function () {
        $(".del_description").on("click", function (event) {
            var id = event.target.id;
            var data = "?image_id=" + id;
//            console.log(id);
            $.ajax({
                type: 'POST',
//                data: data,
                url: "<?php echo $url_delete; ?>" + data,
                beforeSend: function () {
                    $("#preload").show();
                },
                success: function () {
                    $(event.currentTarget).parent().remove();
                    $("#preload").hide();
                }
            });
        });
        $(".choice").sortable({
            handle: ".handle",
            axis: 'y',
            stop: function (event, ui) {
                var data = $(this).sortable('serialize');
                console.log(data);
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: "<?php echo $url_position; ?>",
                });
            },
        });
    });
</script>