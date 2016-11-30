<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "add_description"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i> ' . Yii::t("translation", "back"), 'url' => array('add_presentation_image', 'id' => $model->id), 'encodeLabel' => FALSE),
);

$this->menu_right = array(
    array('label' => Yii::t("translation", "next") . ' <i class="fa fa-arrow-right"></i>', 'url' => array('add_article', 'id' => $model->id), 'encodeLabel' => FALSE),
);

if (!empty($last_model)) {
    $last_count = $last_model->position + 1;
} else {
    $last_count = 0;
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add_description"); ?></h1>
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
                <?php echo Yii::t("translation", "add_description"); ?>
            </div>           
            <div class="panel-body"> 
                <div class="col-lg-7">                             
                    <div class="all_check">
                        <div class="checkbox">
                            <label>
                                <input id="all_check" type="checkbox"> <?php echo Yii::t("translation", "all_check"); ?>
                            </label>
                        </div>                        
                    </div>
                    <form class="form-inline" method="POST">
                        <ul class="list-unstyled choice">  
                            <?php if (!empty($models)) { ?>
                                <?php foreach ($models as $key => $value) { ?>
                                    <li>
                                        <span class="btn btn-default handle"><i class="fa fa-list"></i></span>                                              
                                        <div class="form-group">                                           
                                            <input class="form-control description_box width300" placeholder="<?php echo Yii::t("translation", "description"); ?>" name="Add[<?php echo $key; ?>][description]" value="<?php echo $value->description; ?>">                                           
                                            <input type="hidden" name="Add[<?php echo $key; ?>][id]" value="<?php echo $value->id; ?>"> 
                                        </div> 
                                        <div class="form-group">                                           
                                            <input class="form-control width60" placeholder="<?php echo Yii::t("translation", "point"); ?>" name="Add[<?php echo $key; ?>][point]" value="<?php echo $value->point; ?>">                                           
                                        </div> 
                                        <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>   
                                        <div class="form-group">   
                                            <label class="checkbox-inline">      
                                                <?php if ($value->num == 1) { ?>
                                                    <input type="checkbox" name="Add[<?php echo $key; ?>][num]" checked="1"> <?php echo Yii::t("translation", "number"); ?>
                                                <?php } else { ?>
                                                    <input type="checkbox" name="Add[<?php echo $key; ?>][num]"> <?php echo Yii::t("translation", "number"); ?>  
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <li>
                                    <span class="btn btn-default handle"><i class="fa fa-list"></i></span>                                              
                                    <div class="form-group">                                           
                                        <input class="form-control description_box width300" placeholder="<?php echo Yii::t("translation", "description"); ?>" name="Add[0][description]">                                           
                                    </div> 
                                    <div class="form-group">                                           
                                        <input class="form-control width60" placeholder="<?php echo Yii::t("translation", "point"); ?>" name="Add[0][point]">                                           
                                    </div> 
                                    <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>   
                                    <div class="form-group">   
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Add[0][num]"> <?php echo Yii::t("translation", "number"); ?>
                                        </label>
                                    </div>
                                </li>
                            <?php } ?>                          
                        </ul>
                        <span id="add_description" class="btn btn-default btn-lg width200 margin_bottom_10"><i class="fa fa-plus-circle"></i></span> 
                        <div class="btn-block"><input type="submit" value="<?php echo Yii::t("translation", "add_save"); ?>" name="add_description" class="btn btn-primary"></div>                                         
                    </form> 
                </div>  
                <div class="col-lg-5">                                   
                    <form role="form" method="POST">  
                        <div class="form-group">
                            <label><?php echo Yii::t("translation", "bulk_import"); ?></label>
                            <textarea rows="3" class="form-control" name="Import"></textarea>
                        </div>
                        <div class="btn-block"><input type="submit" value="<?php echo Yii::t("translation", "import"); ?>" name="import_button" class="btn btn-primary"></div>                                       
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
                        <div class="form-group"><input class="form-control width60" placeholder="Point" name="Add[' + current + '][point]"></div> \n\
                        <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>\n\
                        <div class="form-group"><label class="checkbox-inline"><input type="checkbox" name="Add[' + current + '][num]"> <?php echo Yii::t("translation", "number"); ?></label></div>\n\
                    </li>'
                    );
        });

        $(document).on('click', '.del_description', function (event) {
            $(event.currentTarget).parent().remove();
        });

        $('#all_check').click(function () {
            if ($('#all_check').prop('checked')) {
                $('input:checkbox').prop('checked', 'checked');
            } else {
                $('input:checkbox').prop('checked', false);
            }
        });

        function plus(x) {
            var b = $.cookie('last_count');
            var a = parseInt(b) + 1;
            $.cookie('last_count', a);
            return a;
        }
    });
</script>