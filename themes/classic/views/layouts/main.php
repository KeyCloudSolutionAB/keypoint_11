<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php $this->renderPartial('//parts/favicon'); ?>      

        <!-- jQuery -->
        <?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>    
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->



    </head>

    <body>



        <div id="preload">
            <div class="modal-dialog">
                <div class="loader"></div>
            </div>
        </div>

        <?php if (Yii::app()->user->hasFlash('globalerror')) { ?>
            <div class="container">
                <div class="alert alert-danger margin_top_10 margin_bottom_10">
                    <?php echo Yii::app()->user->getFlash('globalerror'); ?>     
                </div>
            </div>

        <?php } ?>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php if (Yii::app()->user->role != 'seller') { ?>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/"><img class="logo" alt="KeyPoint" src="<?php echo Yii::app()->request->baseUrl; ?>/images/key_point_logo_64_2.png"> KeyPoint</a>
                    </div>
                <?php } ?>


                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">                    
                    <?php if (Yii::app()->user->role == 'administrator') { ?>
                        <?php
                        $choose_customer = AdminChoose::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
                        if (!empty($choose_customer)) {
                            $customer_name = $choose_customer->customer->name;
                        } else {
                            $customer_name = '---';
                        }
                        ?>
                        <li>
                            <?php echo CHtml::link(Yii::t("translation", "active_customer") . ': <b>' . $customer_name . '</b>', array('/admin/customer/index')); ?>
                        </li>                     
                    <?php } ?>
                    <?php if (Yii::app()->user->role == 'customer') { ?>
                        <li>
                            <?php echo CHtml::link('<i class="fa fa-lock"></i> ' . Yii::t("translation", "customer_panel"), array('/customer')); ?>                       
                        </li>
                    <?php } ?>
                    <?php if (Yii::app()->user->role == 'administrator') { ?>                   
                        <li>
                            <?php echo CHtml::link('<i class="fa fa-lock"></i> ' . Yii::t("translation", "admin_panel"), array('/admin')); ?>                       
                        </li>
                    <?php } ?>
                    <?php if (Yii::app()->user->role == 'seller') { ?>                   
                        <li>
                            <?php echo CHtml::link('<i class="fa fa-globe"></i> ' . Yii::t("translation", "all_store"), array('all_store/index')); ?>                       
                        </li>
                    <?php } ?>
                    <?php if (!Yii::app()->user->isGuest) { ?>  
                        <li>
                            <?php echo CHtml::link('<i class="fa fa-user"></i> ' . Yii::app()->user->name, array('cabinet/index')); ?>                       
                        </li>
                        <li>
                            <?php echo CHtml::link('<i class="fa fa-sign-out fa-fw"></i> ' . Yii::t("translation", "logout"), array('/site/logout')); ?>                       
                        </li>
                    <?php } ?>

                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <?php $this->renderPartial('/parts/menu'); ?>
                <!-- /.navbar-static-side -->
            </nav>

            <?php
            $style_text = '';
            if (Yii::app()->user->role == 'seller' || Yii::app()->user->isGuest) {
                $style_text = "margin: 0;";
            }
            ?>          
            <div id="page-wrapper" style="<?php echo $style_text; ?>">
                <?php $this->renderPartial('//parts/breadcrumbs'); ?>
                <?php echo $content; ?>    
                <hr>
                <div class="text-center">
                    <p><?php echo Yii::t("translation", "choose_lang"); ?>:</p>
                    <div class="btn-group" role="group">
                        <?php echo CHtml::link('en', '/en', array('class' => 'btn btn-default')); ?>   
                        <?php echo CHtml::link('sv', '/sv', array('class' => 'btn btn-default')); ?>  
                        <?php echo CHtml::link('no', '/no', array('class' => 'btn btn-default')); ?>  
                        <?php echo CHtml::link('da', '/da', array('class' => 'btn btn-default')); ?>  
                        <?php echo CHtml::link('de', '/de', array('class' => 'btn btn-default')); ?>  
                    </div> 
                </div> 
            </div>
            <!-- /#page-wrapper -->



        </div>
        <!-- /#wrapper -->



        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/sb-admin-2.js"></script>

        <!-- progress-circle.js -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/circularloader.js"></script>

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.numpad.js"></script>
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.numpad.css" rel="stylesheet">

        <script type="text/javascript">
            // Set NumPad defaults for jQuery mobile. 
            // These defaults will be applied to all NumPads within this document!
            $.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
            $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
            $.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
            $.fn.numpad.defaults.buttonNumberTpl = '<button type="button" class="btn btn-default"></button>';
            $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
            $.fn.numpad.defaults.onKeypadCreate = function () {
                $(this).find('.done').addClass('btn-primary');
            };
        </script>

    </body>

</html>