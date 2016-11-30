<?php
$this->breadcrumbs = array(
    Yii::t("translation", "dashboards") => array('index'),
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
	$('#dashboard-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/clipboard.min.js"></script>
<script>
    $(document).ready(function () {
        var clipboard = new Clipboard('.btn');
        clipboard.on('success', function (e) {
            alert("<?php echo Yii::t("translation", "you_have_successfully_copied"); ?>");
        });
    });
</script>


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
                    'id' => 'dashboard-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'name' => 'id',
                            'htmlOptions' => array('style' => 'width: 30px'),
                        ),
                        array(
                            'name' => 'key',
                            'type' => 'raw',
                            'value' => '$data->Link',
                        ),
                        array(
                            'name' => 'status',
                            'type' => 'raw',
                            'value' => '$data->setStatus($data->status)',
                            'filter' => FALSE,
                        ),
                        array(
                            'class' => 'ext.TbButtonColumn',
                            'template' => '{view}{update}{delete}',
                        ),
                    ),
                ));
                ?>
            </div>           
        </div>
    </div>
</div>
