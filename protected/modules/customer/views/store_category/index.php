<?php
$this->breadcrumbs = array(
    Yii::t("translation", "store_category") => array('index'),
    Yii::t("translation", "list"),
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#store-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "list"); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">     
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "list"); ?>
            </div>           
            <div class="panel-body">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'store-category-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'name' => 'id',
                            'htmlOptions' => array('style' => 'width: 30px'),
                        ),
                        'title',
//                        'translation_en',
//                        'translation_sv',
//                        'translation_no',
//                        'translation_da',
                        /*
                          'translation_fi',
                          'translation_de',
                         */
                        array(
                            'class' => 'ext.TbButtonColumn',
                        ),
                    ),
                ));
                ?>
            </div>           
        </div>
    </div>
</div>


