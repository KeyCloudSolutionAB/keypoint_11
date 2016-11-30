<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "add_article"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i> ' . Yii::t("translation", "back"), 'url' => array('add_description', 'id' => $model->id), 'encodeLabel' => FALSE),
//    array('label' => Yii::t("translation", "article_check"), 'url' => array('article_check', 'id' => $model->id), 'encodeLabel' => FALSE),
);

$this->menu_right = array(
    array('label' => Yii::t("translation", "next") . ' <i class="fa fa-arrow-right"></i>', 'url' => array('add_image_upload', 'id' => $model->id), 'encodeLabel' => FALSE),
);

if (!empty($last_model)) {
    $last_count = $last_model->position + 1;
} else {
    $last_count = 0;
}

$close = '';
$close_bool = FALSE;

if ($model->add_article == 1) {
    $close = 'display: none;';
    $close_bool = TRUE;
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add_article") . ': ' . $model->title; ?></h1>
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
                <?php echo Yii::t("translation", "add_article"); ?>
                <label style="float: right;">
                    <?php if ($close_bool) { ?>
                        <input style="vertical-align: top;" id="close_panel" type="checkbox" checked> <?php echo Yii::t("translation", "close_or_open"); ?>
                    <?php } else { ?>
                        <input style="vertical-align: top;" id="close_panel" type="checkbox"> <?php echo Yii::t("translation", "close_or_open"); ?>
                    <?php } ?>
                </label>
            </div>           
            <div class="panel-body" id="panel_open_close" style="<?php echo $close; ?>"> 
                <?php if (!empty($sort_array)) { ?>
                    <div class="col-lg-12">
                        <div class="all_check">
                            <div class="checkbox">
                                <div class="form-inline" style="display: inline-block; width: 156px; margin-left: 249px;">
                                    <button type="submit" class="btn btn-default" id="add_default_point">Add</button>
                                    <div class="form-group">                                    
                                        <input type="number" class="form-control" style="width: 60px;" id="default_point_for_all">
                                    </div>                                 
                                </div>     
                                <label style="margin-left: 0px;">
                                    <input id="all_check" type="checkbox"> <?php echo Yii::t("translation", "all_check"); ?>
                                </label>
                            </div>                        
                        </div>
                    </div>
                <?php } ?>


                <div class="col-sm-7">                             

                    <form class="form-inline" method="POST">
                        <ul class="list-unstyled choice" id="xdta"> 
                            <?php if (!empty($sort_array)) { ?>
                                <?php foreach ($sort_array as $key => $value) { ?>
                                    <?php
                                    $art_point = ArticlePoint::model()->findByAttributes(array('scoring_id' => $model->id, 'article_id' => $value->article_id));
                                    if (!empty($art_point)) {
                                        ?>
                                        <li>  
                                            <span data-foo="<?php echo $art_point->position; ?>"></span>
                                            <span class="btn btn-default handle"><i class="fa fa-list"></i></span>     
                                            <div class="form-group">                                           
                                                <input class="form-control description_box width300" name="Add[<?php echo $key; ?>][description]" value="<?php echo $value->article->title; ?>" disabled>                                           
                                                <input type="hidden" name="Add[<?php echo $key; ?>][article_id]" value="<?php echo $value->article_id; ?>"> 
                                            </div> 
                                            <div class="form-group">                                           
                                                <input class="point form-control width60" placeholder="<?php echo Yii::t("translation", "point"); ?>" name="Add[<?php echo $key; ?>][point]" value="<?php echo $art_point->point; ?>">                                           
                                            </div> 
                                            <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>
                                            <div class="form-group">   
                                                <label class="checkbox-inline">
                                                    <?php if ($art_point->num == 1) { ?>
                                                        <input class="checkbox" type="checkbox" name="Add[<?php echo $key; ?>][num]" checked> <?php echo Yii::t("translation", "number"); ?>
                                                    <?php } else { ?>
                                                        <input class="checkbox" type="checkbox" name="Add[<?php echo $key; ?>][num]"> <?php echo Yii::t("translation", "number"); ?>
                                                    <?php } ?>

                                                </label>
                                            </div>
                                        </li>
                                    <?php } else { ?>
                                        <li>   
                                            <span class="btn btn-default handle"><i class="fa fa-list"></i></span>     
                                            <div class="form-group">                                           
                                                <input class="form-control description_box width300" name="Add[<?php echo $key; ?>][description]" value="<?php echo $value->article->title; ?>" disabled>                                           
                                                <input type="hidden" name="Add[<?php echo $key; ?>][article_id]" value="<?php echo $value->article_id; ?>"> 
                                            </div> 
                                            <div class="form-group">                                           
                                                <input class="point form-control width60" placeholder="<?php echo Yii::t("translation", "point"); ?>" name="Add[<?php echo $key; ?>][point]" value="">                                           
                                            </div> 
                                            <span class="btn btn-default del_description"><i class="fa fa-trash"></i></span>
                                            <div class="form-group">   
                                                <label class="checkbox-inline">
                                                    <input class="checkbox" type="checkbox" name="Add[<?php echo $key; ?>][num]"> <?php echo Yii::t("translation", "number"); ?>
                                                </label>
                                            </div>
                                        </li>
                                    <?php } ?>

                                <?php } ?>
                            <?php } ?>

                        </ul>
                        <?php if (!empty($sort_array)) { ?>
                            <input type="submit" value="<?php echo Yii::t("translation", "add_save"); ?>" name="add_article" class="btn btn-primary">                                       
                        <?php } ?>

                        <?php echo CHtml::link(Yii::t("translation", "article_check"), array('article_check', 'id' => $model->id), array('class' => 'btn btn-default', 'style' => 'float:right;')); ?>
                    </form> 
                </div>  
                <div class="col-sm-3">                                   
                    <ul class="list-group">
                        <?php foreach ($models_scoring_cat as $key => $value) { ?>
                            <li class="list-group-item"><?php echo $value->storeCategory->title; ?></li>
                            <?php } ?>      
                    </ul>
                </div>             
            </div>           
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/tinysort.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.tinysort.min.js"></script>
<script>
    $(document).ready(function () {
        $.cookie('last_count', <?php echo $last_count; ?>);

        $(function () {
            $(".choice").sortable({handle: '.handle'});
        });

        $('#add_article').click(function () {
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
            var li = $(event.currentTarget).parent();

        });

        $('#all_check').click(function () {
            if ($('#all_check').prop('checked')) {
                $('.checkbox').prop('checked', 'checked');
            } else {
                $('.checkbox').prop('checked', false);
            }
        });

        function plus(x) {
            var b = $.cookie('last_count');
            var a = parseInt(b) + 1;
            $.cookie('last_count', a);
            return a;
        }

        $('#close_panel').click(function () {
            if ($('#close_panel').prop('checked')) {
                sendAjax();
                $("#panel_open_close").hide();
            } else {
                sendAjax();
                $("#panel_open_close").show();
            }
        });

        var url_change = "<?php echo CHtml::normalizeUrl(array('scoring/changeaddarticle', 'id' => $model->id)); ?>";

        function sendAjax() {
            $.ajax({
                url: url_change,
                success: function () {

                }
            });
        }

        $('#add_default_point').click(function () {
            var default_point = $("#default_point_for_all").val();
            $(".point").val(default_point);
        });

        tinysort('ul#xdta>li', {selector: 'span', data: 'foo'});
    });
</script>