<?php
$this->breadcrumbs = array(
    Yii::t("translation", "stores") => array('index'),
    Yii::t("translation", "list"),
);

$this->menu = array(
    array('label' => '<i class="fa fa-plus"></i>', 'url' => array('create'), 'encodeLabel' => FALSE),
);

$this->menu_right = array(
    array('label' => '<i class="fa fa-cloud-upload"></i>', 'url' => array('import'), 'encodeLabel' => FALSE),
);
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "list"); ?></h1>
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

        <?php $this->renderPartial('_search', array('model' => $model)); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "list"); ?>
            </div>           
            <div class="panel-body">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'enableAjaxValidation' => true,
                ));
                ?>

                <!-- tokenize -->
                <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.tokenize.css" rel="stylesheet">

                <div class="btn-group">
                    <button type="button" class="btn btn-default"><?php echo Yii::t("translation", "action"); ?></button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="link" id="add_seller_button"><?php echo Yii::t("translation", "add_seller"); ?></a></li>
                        <li><a class="link" id="add_tag_button"><?php echo Yii::t("translation", "add_tag"); ?></a></li>                        
                    </ul>
                </div>
                <?php
                if (isset($_GET['page_size'])) {
                    $page_size = (int) $_GET['page_size'];
                } else {
                    $page_size = 10;
                }
                ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo Yii::t("translation", "number_of_rows"); ?> <span class="badge"><?php echo $page_size; ?></span> <span class="caret"></span>
                    </button>                 

                    <ul class="dropdown-menu">                 
                        <li><?php echo CHtml::link('10', array('store/index', 'page_size' => 10)); ?></li>
                        <li><?php echo CHtml::link('100', array('store/index', 'page_size' => 100)); ?></li>
                        <li><?php echo CHtml::link('500', array('store/index', 'page_size' => 500)); ?></li>
                        <li><?php echo CHtml::link('1000', array('store/index', 'page_size' => 1000)); ?></li>
                        <li><?php echo CHtml::link('5000', array('store/index', 'page_size' => 5000)); ?></li>
                    </ul>
                </div>

                <div class="store_sellers_box" id="store_sellers_box" style="display: none;">                   
                    <?php echo $form->labelEx($store_model, 'sellers'); ?>
                    <?php echo $form->dropDownList($store_model, 'sellers', $store_model->getSellers(), array('class' => 'tokenize tokenize_input', 'id' => 'sellers_tokenize', 'multiple' => 'multiple', 'name'=>'sellers_array')); ?>   

                    <?php echo CHtml::submitButton(Yii::t("translation", "add_seller"), array('class' => 'btn btn-default', 'name' => 'add_seller')); ?>
                </div>

                <div class="store_tags_box" id="store_tags_box" style="display: none;">                   
                    <?php echo $form->labelEx($store_model, 'tags'); ?>
                    <?php echo $form->dropDownList($store_model, 'tags', $store_model->getTags(), array('class' => 'tokenize tokenize_input', 'id' => 'tokenize', 'multiple' => 'multiple', 'name'=>'tags_array')); ?>   

                    <?php echo CHtml::submitButton(Yii::t("translation", "add_tag"), array('class' => 'btn btn-default', 'name' => 'add_tag')); ?>
                </div>




                <!-- tokenize -->
                <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.tokenize.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#sellers_tokenize').tokenize();
                        $('#tokenize').tokenize();

                        $('#add_seller_button').click(function () {
                            $("#store_sellers_box").show();
                            $("#store_tags_box").hide()
                        });

                        $('#add_tag_button').click(function () {
                            $("#store_tags_box").show();
                            $("#store_sellers_box").hide()
                        });
                    });
                </script>

                <?php
                // CGridView
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'store-grid',
                    'dataProvider' => $model->search(),
                    'afterAjaxUpdate' => 'reinstallDatePicker',
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'id' => 'autoId',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => '50',
                            'htmlOptions' => array(
                                'style' => 'width: 10px; padding: 0; margin:0;  text-align: center; vertical-align: middle;'
                            ),
                        ),
                        array(
                            'name' => 'id',
                            'htmlOptions' => array('style' => 'width: 30px'),
                        ),
                        array(
                            'name' => 'tags',
                            'type' => 'raw',
                            'value' => '$data->getAllTags()',
                            'filter' => CHtml::dropDownList('Store[tags]', 'Store[tags]', $model->Tags, array('class' => 'form-control', 'empty' => '')),
                        ),
                        array(
                            'name' => 'store_category_id',
                            'value' => '$data->setStoreCategoryId($data->store_category_id)',
                            'type' => 'raw',
                            'filter' => CHtml::dropDownList('Store[store_category_id]', 'Store[store_category_id]', $model->StoreCategoryId, array('class' => 'form-control', 'empty' => '')),
                        ),
                        'storename',
                        array(
                            'name' => 'sellers',
                            'type' => 'raw',
                            'value' => '$data->getAllSellers()',
                           'filter' => CHtml::dropDownList('Store[sellers]', 'Store[sellers]', $model->Sellers, array('class' => 'form-control', 'empty' => '')),
                        ),
                        'city',
                        //                        'adress',
                        //                        'zip',                       
                        //                        'city_id',
                        //                        'user.contact_name',
                        /*
                          'phone',
                          'email',
                          'note',
                          'lang',
                          'create_time',
                          'update_time',
                          'status',

                         */
                        array(
                            'class' => 'ext.TbButtonColumn',
                        ),
                    ),
                ));

                //
                Yii::app()->clientScript->registerScript('re-install-date-picker', "function reinstallDatePicker(id, data) { }");
                ?>

                <script>
                    function reloadGrid(data) {
                        $.fn.yiiGridView.update('store-grid');
                    }
                </script>

                <?php $this->endWidget(); ?>    

            </div>           
        </div>
    </div>
</div>