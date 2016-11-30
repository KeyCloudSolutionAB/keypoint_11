<div class="row">
    <div class="col-lg-12 margin_top_10">
        <?php if (Yii::app()->user->hasFlash('good')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('good'); ?>
            </div>
        <?php } ?>
        <div class="margin_bottom_10">    
            <?php echo CHtml::link('<i class="fa fa-chevron-left"></i> ' . Yii::t("translation", "back"), array('/my_scoreing'), array('class' => 'btn btn-default')); ?>
            <?php echo CHtml::link('<i class="fa fa-plus"></i>', array('/store/add'), array('class' => 'btn btn-default')); ?>

        </div>    

        <div class="margin_bottom_10 text-center">             
            <div class="btn-group" role="group">               
                <?php echo CHtml::link(Yii::t("translation", "my_all_stores"), '#', array('class' => 'btn btn-myprimary')); ?>
                <?php echo CHtml::link(Yii::t("translation", "team_stores"), array('/all_store/team'), array('class' => 'btn btn-default')); ?>                                    
            </div>           
        </div>    

<!--        <h3><?php // echo Yii::t("translation", "all_store");                 ?></h3>       -->


        <div class="table-responsive scorename_table">           
            <table class="table table-striped table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th>
                            <?php echo Yii::t("translation", "my_all_store"); ?>
                        </th>  
                    </tr>
                    <tr class="filters">
                        <td>
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'method' => 'GET',
                                'action' => CHtml::normalizeUrl(array('all_store/index')),
                            ));

                            if (isset($_GET['q'])) {
                                $q = CHtml::encode($_GET['q']);
                            }
                            ?>
                            <div class="form-group input-group">
                                <?php if (!empty($q)) { ?>
                                    <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="q">
                                <?php } ?>

                                <span class="input-group-btn">
                                    <button name="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <?php $this->endWidget(); ?>
                        </td>  
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($all_stores)) {
                        foreach ($all_stores as $key => $value) {
                            $store_url = CHtml::normalizeUrl(array('all_store/view', 'id' => $value['id']));
                            ?> 
                            <tr>
                                <td>              
                                    <a href="<?php echo $store_url; ?>" class="text_decoration_none">                                                           
                                        <div class="storename_table_title">
                                            <i class="fa fa-flag"></i>
                                            <?php echo $value['storename']; ?>
                                            <div><i class="fa fa-map-marker"></i> <?php echo $value['city']; ?></div> 
                                        </div>
                                    </a> 
                                </td> 
                            </tr>
                            <?php
                        }
                    }
                    ?>                   
                </tbody>
            </table>           
        </div>   

    </div>
    <!-- /.col-lg-12 -->                   
</div>