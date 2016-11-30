<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->renderPartial('//parts/favicon'); ?>

        <title><?php echo Yii::app()->name; ?> - <?php echo Yii::t("translation", "new_password"); ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

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

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">   
                    <div class="login-panel">    
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
                                <h1 class="panel-title text-center"><?php echo Yii::app()->name; ?></h1>
                            </div>
                            <div class="panel-body">
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'user-form',
                                    'enableAjaxValidation' => false,
                                    'htmlOptions' => array(
                                        'role' => 'form',
                                    ),
                                ));
                                ?>                              
                                <fieldset>
                                    <div class="form-group">                                        
                                        <?php echo $form->textField($model, 'password', array('class' => 'form-control', 'placeholder' => Yii::t("translation", "new_password"))); ?>
                                        <?php echo $form->error($model, 'password'); ?>
                                    </div> 

                                    <?php echo CHtml::submitButton(Yii::t("translation", "save"), array('class' => 'btn btn-success')); ?>                                    
                                </fieldset>
                                <?php $this->endWidget(); ?>                              
                            </div>
                            <div class="panel-footer text-center">
                                <a href="http://www.keyplansolution.com/" target="_blank"><?php echo Yii::t("translation", "more_information_keyplansolution"); ?></a>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>



    </body>

</html>
