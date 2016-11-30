<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">            
            <?php
            echo '<li>';
            echo CHtml::link('<i class="fa fa-line-chart"></i> ' . Yii::t("translation", "dashboard"), array('/customer/default/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-home"></i> ' . Yii::t("translation", "stores"), array('/customer/store/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-outdent"></i> ' . Yii::t("translation", "store_category"), array('/customer/store_category/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-tags"></i> ' . Yii::t("translation", "tags"), array('/customer/tag/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-street-view"></i> ' . Yii::t("translation", "team_name"), array('/customer/team_name/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-users"></i> ' . Yii::t("translation", "team"), array('/customer/team/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-user"></i> ' . Yii::t("translation", "seller"), array('/customer/seller/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-check-square-o"></i> ' . Yii::t("translation", "scoring"), array('/customer/scoring/index'));
            echo '</li>';
            echo '<li>';
            echo CHtml::link('<i class="fa fa-cogs"></i> ' . Yii::t("translation", "settings"), array('/customer/settings/index'));
            echo '</li>';
            ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>