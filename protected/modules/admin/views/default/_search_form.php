<div class="panel panel-default">                          
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'search_seller-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-inline'),
        ));
        ?>      
        <div class="form-group">                                           
            <input name="search_seller" type="text" class="form-control" placeholder="<?php echo Yii::t("translation", "search_seller"); ?>">
        </div>                                       
        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        <?php $this->endWidget(); ?>
    </div>                            
</div>    