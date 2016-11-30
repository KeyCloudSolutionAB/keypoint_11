<?php
$this->breadcrumbs = array(
    Yii::t("translation", "articles"),
    Yii::t('translation', 'list'),
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "list"); ?>
            </div>           
            <div class="panel-body">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'article-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
//                        'id',
                        array(
                            'name' => 'article_category_id',
                            'value' => '$data->ArticleCategoryName',
                            'type' => 'raw',
                            'filter' => CHtml::dropDownList('Article[article_category_id]', 'Article[article_category_id]', $model->AllArticleCategory, array('class' => 'form-control', 'empty' => '')),
                        ),
//                        'article_category_id',
                        'title',
                        'article_id',
                        'cpg',
                        /*
                          'ean',
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






