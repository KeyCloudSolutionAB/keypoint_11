<?php
$this->breadcrumbs = array(
    Yii::t("translation", "art_cats") => array('index'),
    Yii::t('translation', 'add2'),
);

$this->menu = array(
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
);
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "add2"); ?></h1>
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

        <?php $this->renderPartial('_cat2', array('model' => $model_artcat)); ?>       
        <hr>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "add2"); ?>
            </div>           
            <div class="panel-body">                
                <?php
                if ($model_artcat->store_category_id != NULL) {
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'art-cat-form',
                        'enableAjaxValidation' => false,
                    ));
                    echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default'));
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'article-grid',
                        'dataProvider' => $model->search_no_pagination(),
                        'filter' => $model,
                        'columns' => array(
                            array(
                                'name' => 'article_category_id',
                                'value' => '$data->articleCategory->title',
                                'type' => 'raw',
                                'filter' => CHtml::dropDownList('Article[article_category_id]', 'Article[article_category_id]', $model->AllArticleCategory, array('class' => 'form-control', 'empty' => '')),
                            ),
                            'title',
                            'article_id',
                            'cpg',
                            'ean',
                            array(
                                'name' => 'value',
                                'type' => 'raw',
                                'value' => 'CHtml::textField("ArticleID[$data->id]", $data->getArtCat(' . $model_artcat->store_category_id . '), array("class" => "form-control"))',
                                'filter' => FALSE
                            ),
                        ),
                    ));
                    echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default'));
                    $this->endWidget();
                }
                ?>          
            </div>           
        </div>
    </div>
