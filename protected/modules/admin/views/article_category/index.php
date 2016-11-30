<?php
$this->breadcrumbs = array(
    Yii::t("translation", "article_categories"),
    Yii::t('translation', 'list'),
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "list"); ?>
            </div>           
            <div class="panel-body">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'article-category-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
//                        'id',
                        'title',
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



