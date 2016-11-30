<?php
$this->breadcrumbs = array(
    Yii::t("translation", "dashboards") => array('index'),
    Yii::t("translation", "filters"),
);
?>


<?php if (Yii::app()->user->hasFlash('error')) { ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>     
    </div>
<?php } ?>
<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "filters"); ?></h1>
    </div>   
</div>

<div class="row">
    <div class="col-lg-12">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>

        <?php if (Yii::app()->user->hasFlash('reset')) { ?>
            <div class="alert alert-info">
                <?php echo Yii::app()->user->getFlash('reset'); ?>
            </div>
        <?php } ?>

        <div class="panel panel-default">                          
            <div class="panel-body">
                <?php echo CHtml::link('<i class="fa fa-arrow-left"></i>', array('default/index'), array('class' => 'btn btn-default')); ?>                            
            </div>                            
        </div>     
        <div class="panel panel-default">                          
            <div class="panel-body">   
                <?php $link = CHtml::normalizeUrl(array('default/filters')); ?>
                <form class="form" method="POST" action="<?php echo $link; ?>">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php echo Yii::t("translation", "scorlist"); ?></label>
                            <?php
                            $all_filter_scorlist = $model_filter_scorlist->Scorings;
                            $all_scorlist = FilterScorlist::model()->checkScorings(Yii::app()->params['choose_customer']);
                            ?>
                            <select name="scorlist[]" class="form-control form_control_multiple" multiple="">
                                <?php foreach ($all_filter_scorlist as $key => $value) { ?>
                                    <?php
                                    $select = FALSE;
                                    if (array_key_exists($key, $all_scorlist)) {
                                        $select = TRUE;
                                    }
                                    ?>
                                    <option <?php echo $select === TRUE ? 'selected="selected="' : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>   
                            </select>
                        </div> 
                    </div>  
                    <div class="col-lg-6">                                                                      
                        <div class="form-group">
                            <label><?php echo Yii::t("translation", "category"); ?></label>
                            <?php
                            $all_filter_category = $model_filter_category->Categories;
                            $all_category = FilterCategory::model()->checkCategories(Yii::app()->params['choose_customer']);
                            ?>
                            <select name="category[]" class="form-control form_control_multiple" multiple="">
                                <?php foreach ($all_filter_category as $key => $value) { ?>
                                    <?php
                                    $select = FALSE;
                                    if (array_key_exists($key, $all_category)) {
                                        $select = TRUE;
                                    }
                                    ?>
                                    <option <?php echo $select === TRUE ? 'selected="selected="' : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>   
                            </select>                                                   
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php echo Yii::t("translation", "tags"); ?></label>
                            <?php
                            $all_filter_tags = $model_filter_tags->Tags;
                            $all_tags = FilterTags::model()->checkTags(Yii::app()->params['choose_customer']);
                            ?>
                            <select name="tags[]" class="form-control form_control_multiple" multiple="">
                                <?php foreach ($all_filter_tags as $key => $value) { ?>
                                    <?php
                                    $select = FALSE;
                                    if (array_key_exists($key, $all_tags)) {
                                        $select = TRUE;
                                    }
                                    ?>
                                    <option <?php echo $select === TRUE ? 'selected="selected="' : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>     
                            </select>   
                        </div>    
                    </div>  
                    <div class="col-lg-12">
                        <input type="submit" value="<?php echo Yii::t("translation", "save"); ?>" name="save" class="btn btn-default">
                        <input type="submit" value="<?php echo Yii::t("translation", "reset_all"); ?>" name="reset_all" class="btn btn-default">
                    </div>
                </form>  
            </div>                            
        </div>  
    </div>
</div>