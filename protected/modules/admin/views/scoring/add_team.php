<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "add_team"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-arrow-left"></i> '. Yii::t("translation", "back"), 'url' => array('add_store_category_tag', 'id' => $model->id), 'encodeLabel' => FALSE),
);

$this->menu_right = array(
    array('label' => Yii::t("translation", "next") . ' <i class="fa fa-arrow-right"></i>', 'url' => array('add_presentation_image', 'id' => $model->id), 'encodeLabel' => FALSE),
);
?>


<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/multiple-select.css" rel="stylesheet">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/multiple-select.js"></script>  

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add_team"); ?></h1>
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
                <p id="eventResult" style="display: none;">Here is the result of event.</p>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'add-team-form',
                    'enableAjaxValidation' => false,
                ));
                ?>
                <select multiple="multiple" name="Sellers[]">
                    <?php echo $string; ?>
                </select>

                <?php echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-primary')); ?>  
                <?php $this->endWidget(); ?>
            </div>           
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var $eventResult = $('#eventResult');
        $("select").multipleSelect({
            onOpen: function () {
                $eventResult.text('Select opened!');
            },
            onClose: function () {
                $eventResult.text('Select closed!');
            },
            onCheckAll: function () {
                $eventResult.text('Check all clicked!');
            },
            onUncheckAll: function () {
                $eventResult.text('Uncheck all clicked!');
            },
            onFocus: function () {
                $eventResult.text('focus!');
            },
            onBlur: function () {
                $eventResult.text('blur!');
            },
            onOptgroupClick: function (view) {
                var values = $.map(view.children, function (child) {
                    return child.value;
                }).join(', ');
                $eventResult.text('Optgroup ' + view.label + ' ' +
                        (view.checked ? 'checked' : 'unchecked') + ': ' + values);
            },
            onClick: function (view) {
                $eventResult.text(view.label + '(' + view.value + ') ' +
                        (view.checked ? 'checked' : 'unchecked'));
            }
        });
    });
</script>