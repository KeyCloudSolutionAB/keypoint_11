<?php
$this->breadcrumbs = array(
    Yii::t("translation", "scoring") => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => Yii::t("translation", "create"), 'url' => array('create')),
    array('label' => Yii::t("translation", "list"), 'url' => array('index')),
    array('label' => Yii::t("translation", "update"), 'url' => array('update', 'id' => $model->id)),  
);
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $model->title; ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">     
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("translation", "start_time"); ?>: <span class="label label-default"><?php echo $model->start_time; ?></span> | <?php echo Yii::t("translation", "end_time"); ?>: <span class="label label-default"><?php echo $model->end_time; ?></span>
            </div>           
            <div class="panel-body">              
                <div class="col-md-4">
                    <h4><?php echo Yii::t("translation", "store_category"); ?></h4>
                    <?php if (!empty($cats)) { ?>
                        <ul class="list-group">
                            <?php foreach ($cats as $key => $value) { ?>
                                <li class="list-group-item"><?php echo $value->storeCategory->title; ?></li>
                            <?php } ?>                     
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <h4><?php echo Yii::t("translation", "tags"); ?></h4>
                    <?php if (!empty($tags)) { ?>                      
                        <ul class="list-group">
                            <?php foreach ($tags as $key => $value) { ?>
                                <li class="list-group-item"><?php echo $value->tag->title; ?></li>
                            <?php } ?>                     
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-md-4">                   
                    <h4><?php echo Yii::t("translation", "sellers"); ?></h4>
                    <?php if (!empty($sellers)) { ?>
                        <ul class="list-group">
                            <?php foreach ($sellers as $key => $value) { ?>
                                <li class="list-group-item"><?php echo $value->user->name; ?></li>
                            <?php } ?>                     
                        </ul>
                    <?php } ?>
                </div>
                <hr>
                <div class="col-md-4">                 
                    <h4><?php echo Yii::t("translation", "images"); ?></h4>
                    <?php if (!empty($presentation_image)) { ?>
                        <div class="">
                            <?php foreach ($presentation_image as $key => $value) { ?>
                                <img alt="" class="img-thumbnail width100" src="<?php echo Yii::app()->request->baseUrl; ?>/upload_files/scoring_image/<?php echo $value->image; ?>">
                            <?php } ?>                     
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-4">                 
                    <h4><?php echo Yii::t("translation", "description"); ?></h4>
                    <?php if (!empty($description)) { ?>
                        <ul class="list-group">
                            <?php foreach ($description as $key => $value) { ?>
                                <li class="list-group-item"><?php echo $value->description . ' (' . $value->point . ')'; ?></li>
                            <?php } ?>                     
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-md-4">                 
                    <h4><?php echo Yii::t("translation", "scoring_image_upload_id"); ?></h4>
                    <?php if (!empty($upload_image)) { ?>
                        <ul class="list-group">
                            <?php foreach ($upload_image as $key => $value) { ?>
                                <li class="list-group-item"><?php echo $value->description . ' (' . $value->point . ')'; ?></li>
                            <?php } ?>                     
                        </ul>
                    <?php } ?>
                </div>





            </div>   
            <div class="panel-footer">
                <?php echo Yii::t("translation", "note"); ?>: <?php echo $model->note; ?>
            </div>
        </div>
    </div>
</div>
