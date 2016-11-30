<?php $this->beginContent('//layouts/main'); ?>



<?php if (!empty($this->menu) || !empty($this->menu_right)) { ?>
    <div class="row">        
        <div class="col-lg-12">
            <div class="panel panel-default">     
                <div class="panel-body commands">
                    <?php if (!empty($this->menu)) { ?>
                        <div class="col-xs-6" style="padding-left: 0;">  
                            <?php
                            $this->widget('zii.widgets.CMenu', array(
                                'items' => $this->menu,
                                'linkLabelWrapper' => 'span',
                                'linkLabelWrapperHtmlOptions' => array('class' => 'btn btn-default btn-block'),
                                'htmlOptions' => array('class' => 'list-unstyled list-inline', 'style' => 'margin-bottom:0;'),
                            ));
                            ?>
                        </div>   
                    <?php } ?>
                    <?php if (!empty($this->menu_right)) { ?>
                        <div class="col-xs-6 text-right" style="padding-right: 0;">  
                            <?php
                            $this->widget('zii.widgets.CMenu', array(
                                'items' => $this->menu_right,
                                'linkLabelWrapper' => 'span',
                                'linkLabelWrapperHtmlOptions' => array('class' => 'btn btn-default btn-block'),
                                'htmlOptions' => array('class' => 'list-unstyled list-inline', 'style' => 'margin-bottom:0;'),
                            ));
                            ?>
                        </div>   
                    <?php } ?>
                </div>  
            </div>
        </div>         
    </div>
<?php } ?>



<?php echo $content; ?>




<?php $this->endContent(); ?>