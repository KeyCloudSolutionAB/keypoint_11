<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "add_store_category_tag"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i> ' . Yii::t("translation", "back"), 'url' => array('update', 'id' => $model->id), 'encodeLabel' => FALSE),
);

$this->menu_right = array(
    array('label' => Yii::t("translation", "next") . ' <i class="fa fa-arrow-right"></i>', 'url' => array('add_team', 'id' => $model->id), 'encodeLabel' => FALSE),
);
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add_store_category_tag"); ?></h1>
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
    </div>
    <!-- /.col-lg-12 -->
</div>



<!-- tokenize -->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.tokenize.css" rel="stylesheet">

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'add-store-tag-form-index-form',
    'enableAjaxValidation' => false,
        ));
?>

<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo Yii::t("translation", "add_store_category"); ?>
        </div>
        <div class="panel-body">     
            <input id="select_all" type="checkbox" name="select_all">
            <label style="vertical-align: middle !important;" for="select_all"><?php echo Yii::t("translation", "select_all"); ?></label>          


            <div class="form-group checkbox_box">   
                <?php echo $form->checkBoxList($model_add_scoring_tag, 'store_category', $model_add_scoring_tag->getStoreCategory()); ?>                
            </div>
        </div>                                           
    </div> 
</div>   

<div class="col-lg-6">     
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo Yii::t("translation", "add_tag"); ?>           
        </div>
        <div class="panel-body">               
            <?php echo $form->dropDownList($model_add_scoring_tag, 'tags', $model_add_scoring_tag->getTags(), array('class' => 'tokenize', 'id' => 'tokenize', 'multiple' => 'multiple')); ?>   



        </div>                                           
    </div> 
</div>  

<div class="col-lg-12">
    <?php echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-primary')); ?>   
</div>

<?php $this->endWidget(); ?>

<!-- tokenize -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.tokenize.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tokenize').tokenize();
        $('#select_all').change(function () {
            if ($(this).is(':checked')) {
                $(".checkbox_box input[type='checkbox']").prop("checked", true);
            } else {
                $(".checkbox_box input[type='checkbox']").prop("checked", false);
            }
        });
    });
</script>