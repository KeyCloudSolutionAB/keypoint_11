<?php
if (isset($_GET['sendmailtest'])) {

    $registration_code = Yii::app()->createAbsoluteUrl('/login/registration', array('registration_code' => 'registration_code'));

    //       
    $mail = new YiiMailer();
    $mail->setView('new_user');
    $mail->setData(
            array(
                'getname' => 'getname',
                'registration_code' => 'registration_code',
                'email' => 'samir_101@mail.ru',
                'password' => 'password',
            )
    );
    //
    $mail->setFrom(Yii::app()->params['adminEmail'], Yii::app()->params['adminName']);
    $mail->setSubject(Yii::t("translation", "you_new_password"));
    $mail->setTo(array('samir_101@mail.ru' => 'name'));
    $mail->setReplyTo(Yii::app()->params['adminEmail']);
    if ($mail->send()) {
        echo 'Thank you for contacting us. We will respond to you as soon as possible.';
    } else {
        echo $mail->getError();
    }

  
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->renderPartial('//parts/favicon'); ?>

        <title><?php echo Yii::app()->name; ?> - <?php echo Yii::t("translation", "sign_in"); ?></title>

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
                                    'id' => 'login-form',
                                    'enableClientValidation' => true,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                    ),
                                    'htmlOptions' => array(
                                        'role' => 'form',
                                    ),
                                ));
                                ?>
                                <fieldset>
                                    <div class="form-group">                                        
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => Yii::t("translation", "email"))); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>

                                    <div class="form-group">                                       
                                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => Yii::t("translation", "password"))); ?>
                                        <?php echo $form->error($model, 'password'); ?>   
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <?php echo $form->checkBox($model, 'rememberMe'); ?><?php echo Yii::t("translation", "remember_me_next_time"); ?>                                       
                                        </label>
                                        <div class="lost_my_password"><?php echo CHtml::link(Yii::t("translation", "lost_my_password"), array('login/password')); ?></div>
                                    </div> 

                                    <?php echo CHtml::submitButton(Yii::t("translation", "sign_in"), array('class' => 'btn btn-lg btn-success btn-block')); ?>
                                </fieldset>
                                <?php $this->endWidget(); ?>                              
                            </div>
                            <div class="panel-footer text-center">
                                <a href="http://www.keyplansolution.com/" target="_blank"><?php echo Yii::t("translation", "more_information_keyplansolution"); ?></a>  
                            </div>                            
                        </div>
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
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>

</html>
