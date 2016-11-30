<?php if (isset($this->breadcrumbs)) { ?>
    <div class="row">
        <div class="col-lg-12">
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'htmlOptions' => array(
                    'class' => 'breadcrumb'
                ),
            ));
            ?>         
        </div>   
    </div>
<?php } ?>