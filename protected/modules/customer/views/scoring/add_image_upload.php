<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "add_image_upload"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i> ' . Yii::t("translation", "back"), 'url' => array('add_description', 'id' => $model->id), 'encodeLabel' => FALSE),
);

if (!empty($last_model)) {
    $last_count = $last_model->position;
} else {
    $last_count = 0;
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add_image_upload"); ?></h1>
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
                <?php echo Yii::t("translation", "add_image_upload"); ?>
            </div>           
            <div class="panel-body"> 
                <div class="col-lg-7">                             
                    <form class="form-inline" method="POST">

                        <ul class="list-unstyled choice">  
                            <?php if (!empty($models)) { ?>
                                <?php foreach ($models as $key => $value) { ?>
                                    <li>
                                        <span class="btn btn-default handle"><i class="fa fa-list"></i></span>                                              
                                        <div class="form-group">                                           
                                            <input class="form-control description_box width300" placeholder="Description" name="Add[<?php echo $key; ?>][description]" value="<?php echo $value->description; ?>">                                           
                                            <input type="hidden" name="Add[<?php echo $key; ?>][id]" value="<?php echo $value->id; ?>"> 

                                        </div> 
                                        <div class="form-group">                                           
                                            <input class="form-control width50" placeholder="Point" name="Add[<?php echo $key; ?>][point]" value="<?php echo $value->point; ?>">                                           
                                        </div> 
                                        <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>   
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <li>
                                    <span class="btn btn-default handle"><i class="fa fa-list"></i></span>                                              
                                    <div class="form-group">                                           
                                        <input class="form-control description_box width300" placeholder="Description" name="Add[0][description]">                                           
                                    </div> 
                                    <div class="form-group">                                           
                                        <input class="form-control width50" placeholder="Point" name="Add[0][point]">                                           
                                    </div> 
                                    <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>   
                                </li>
                            <?php } ?>                          
                        </ul>
                        <span id="add_description" class="btn btn-default btn-lg width200 margin_bottom_10"><i class="fa fa-plus-circle"></i></span> 
                        <div class="btn-block"><input type="submit" value="<?php echo Yii::t("translation", "add_save"); ?>" name="add_description" class="btn btn-primary"></div>                                         
                    </form> 
                </div>                             
            </div>           
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script>
    $(document).ready(function () {
        $.cookie('last_count', <?php echo $last_count; ?>);

        $(function () {
            $(".choice").sortable({handle: '.handle'});
        });

        $('#add_description').click(function () {
            var current = plus();
            $(".choice").append(
                    '<li>\n\
                        <span class="btn btn-default handle"><i class="fa fa-list"></i></span> \n\
                        <div class="form-group"><input class="form-control description_box width300" placeholder="Description" name="Add[' + current + '][description]"></div> \n\
                        <div class="form-group"><input class="form-control width50" placeholder="Point" name="Add[' + current + '][point]"></div> \n\
                        <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>\n\
                    </li>'
                    );
        });

        $(document).on('click', '.del_description', function (event) {
            $(event.currentTarget).parent().remove();
        });



        function plus(x) {
            var b = $.cookie('last_count');
            var a = parseInt(b) + 1;
            $.cookie('last_count', a);
            return a;
        }
    });
</script>