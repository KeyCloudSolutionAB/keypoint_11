<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    Yii::t("translation", "article_check"),
);
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t("translation", "article_check") . ': ' . $model_scoring->title; ?></h1>
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
                <?php echo Yii::t("translation", "article_check"); ?>                
            </div>           
            <div class="panel-body">                
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'art-cat-form',
                    'enableAjaxValidation' => false,
                ));
                echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default'));
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'article-grid',
                    'dataProvider' => $model_article->search_for_check($sort_array),
                    'filter' => $model_article,
                    'columns' => array(
                        array(
                            'name' => 'article_category_id',
                            'value' => '$data->articleCategory->title',
                            'type' => 'raw',
                            'filter' => CHtml::dropDownList('Article[article_category_id]', 'Article[article_category_id]', $model_article->AllArticleCategory, array('class' => 'form-control', 'empty' => '')),
                        ),
                        'title',
                        'article_id',
                        'cpg',
                        'ean',
                        array(
                            'name' => 'check',
                            'id' => 'selectedIds',
                            'value' => '$data->id',
                            'checked' => '$data->getArtCheck(' . $model_scoring->id . ')',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => '100',
                        ),                       
                    ),
                ));
                echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default'));
                $this->endWidget();
                ?>          
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

    });
</script>