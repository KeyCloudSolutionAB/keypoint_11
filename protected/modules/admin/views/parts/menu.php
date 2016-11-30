<?php
$choose_customer = AdminChoose::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
if (!empty($choose_customer)) {
    $customer_name = $choose_customer->customer->name;
} else {
    $customer_name = '---';
}
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">  
            <li>
                <?php echo CHtml::link('<i class="fa fa-line-chart"></i> ' . Yii::t("translation", "dashboard"), array('/admin/default')); ?>
            </li>  
            <li>
                <?php echo CHtml::link('<i class="fa fa-exchange"></i> ' . Yii::t("translation", "translation"), array('/admin/translation/index')); ?>
            </li>           
            <li>
                <?php echo CHtml::link('<i class="fa fa-user-secret"></i> ' . Yii::t("translation", "customers"), array('/admin/customer/index')); ?>
            </li>
            <?php
            if (!empty($choose_customer)) {
                echo '<li>';
                echo CHtml::link('<i class="fa fa-home"></i> ' . Yii::t("translation", "stores"), array('/admin/store/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-outdent"></i> ' . Yii::t("translation", "store_category"), array('/admin/store_category/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-tags"></i> ' . Yii::t("translation", "tags"), array('/admin/tag/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-street-view"></i> ' . Yii::t("translation", "team_name"), array('/admin/team_name/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-users"></i> ' . Yii::t("translation", "team"), array('/admin/team/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-user"></i> ' . Yii::t("translation", "seller"), array('/admin/seller/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-check-square-o"></i> ' . Yii::t("translation", "scoring"), array('/admin/scoring/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-cogs"></i> ' . Yii::t("translation", "settings"), array('/admin/settings/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-home"></i> ' . Yii::t("translation", "article_category"), array('/admin/article_category/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-home"></i> ' . Yii::t("translation", "articles_relations"), array('/admin/art_cat/add2'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-home"></i> ' . Yii::t("translation", "article"), array('/admin/article/index'));
                echo '</li>';
                echo '<li>';
                echo CHtml::link('<i class="fa fa-home"></i> ' . Yii::t("translation", "art_cats"), array('/admin/art_cat/index'));
                echo '</li>';
            }
            ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>