<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'art-cat-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>

<br><br>

<table class="table" style="width: 80%;">
    <tr>
        <th><?php echo Yii::t("translation", "article_category"); ?></th>
        <th><?php echo Yii::t("translation", "article_id"); ?></th>
        <th><?php echo Yii::t("translation", "article"); ?></th>
        <th><?php echo Yii::t("translation", "value"); ?></th>
    </tr>

    <?php foreach ($models as $key => $value) { ?>
        <?php $model = ArtCat::model()->findByAttributes(array('store_category_id' => $store_category_id, 'article_id' => $value->id)); ?>
        <?php if (!empty($model)) { ?>
            <tr>   
                <td>
                    <?php echo $value->articleCategory->title; ?>                    
                </td>
                <td>
                    <?php echo $value->article_id; ?>                    
                </td>
                <td>
                    <?php echo $value->title; ?>
                    <input value="<?php echo $value->id; ?>" type="hidden" name="ArrayArtCat[<?php echo $key; ?>][article_id]">          
                </td>
                <td>
                    <input value="<?php echo $model->value; ?>" type="text" class="form-control" name="ArrayArtCat[<?php echo $key; ?>][value]">      
                </td>
            </tr>
        <?php } else { ?>
            <tr>    
                 <td>
                    <?php echo $value->articleCategory->title; ?>                    
                </td>
                <td>
                    <?php echo $value->article_id; ?>                    
                </td>
                <td>
                    <?php echo $value->title; ?>
                    <input value="<?php echo $value->id; ?>" type="hidden" name="ArrayArtCat[<?php echo $key; ?>][article_id]">          
                </td>
                <td>
                    <input type="text" class="form-control" name="ArrayArtCat[<?php echo $key; ?>][value]">      
                </td>
            </tr>
        <?php } ?>

    <?php } ?>   
</table>

<?php echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-default')); ?>

<?php $this->endWidget(); ?>
