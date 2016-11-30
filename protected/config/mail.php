<?php

return array(
    'viewPath' => 'application.views.mail',
    'layoutPath' => 'application.views.layouts',
    'baseDirPath' => 'webroot.images.mail', //note: 'webroot' alias in console apps may not be the same as in web apps
    'savePath' => 'webroot.assets.mail',
    'testMode' => false,
    'layout' => 'mail',
    'CharSet' => 'UTF-8',
    'AltBody' => Yii::t('YiiMailer', 'You need an HTML capable viewer to read this message.'),
    'language' => array(
        'authenticate' => Yii::t('YiiMailer', 'SMTP Error: Could not authenticate.'),
        'connect_host' => Yii::t('YiiMailer', 'SMTP Error: Could not connect to SMTP host.'),
        'data_not_accepted' => Yii::t('YiiMailer', 'SMTP Error: Data not accepted.'),
        'empty_message' => Yii::t('YiiMailer', 'Message body empty'),
        'encoding' => Yii::t('YiiMailer', 'Unknown encoding: '),
        'execute' => Yii::t('YiiMailer', 'Could not execute: '),
        'file_access' => Yii::t('YiiMailer', 'Could not access file: '),
        'file_open' => Yii::t('YiiMailer', 'File Error: Could not open file: '),
        'from_failed' => Yii::t('YiiMailer', 'The following From address failed: '),
        'instantiate' => Yii::t('YiiMailer', 'Could not instantiate mail function.'),
        'invalid_address' => Yii::t('YiiMailer', 'Invalid address'),
        'mailer_not_supported' => Yii::t('YiiMailer', ' mailer is not supported.'),
        'provide_address' => Yii::t('YiiMailer', 'You must provide at least one recipient email address.'),
        'recipients_failed' => Yii::t('YiiMailer', 'SMTP Error: The following recipients failed: '),
        'signing' => Yii::t('YiiMailer', 'Signing Error: '),
        'smtp_connect_failed' => Yii::t('YiiMailer', 'SMTP Connect() failed.'),
        'smtp_error' => Yii::t('YiiMailer', 'SMTP server error: '),
        'variable_set' => Yii::t('YiiMailer', 'Cannot set or reset variable: ')
    ),
    // ************************* //
//    'Mailer' => 'smtp',
//    'Host' => 'smtp.gmail.com',
//    'Port' => 465,
//    'SMTPSecure' => 'ssl',
//    'SMTPAuth' => true,
//    'Username' => 'onlymymail1001@gmail.com',
//    'Password' => '4389gyhwg3ghsf',  // 7y9gsh0ghas
        // ************************* //
//    'Mailer' => 'smtp',
//    'Host' => 'smtp.gmail.com',
//    'Port' => 465,
//    'SMTPSecure' => 'ssl',
//    'SMTPAuth' => true,
//    'Username' => 'agrobank.uz@gmail.com',
//    'Password' => '258agro258963',
        //        Yii::app()->mailer->IsSMTP(); // telling the class to use SMTP
//        Yii::app()->mailer->SMTPDebug = false;
//        Yii::app()->mailer->SMTPAuth = true;                  // enable SMTP authentication
//        Yii::app()->mailer->SMTPSecure = "tls";                 // sets the prefix to the servier
//        Yii::app()->mailer->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
//        Yii::app()->mailer->Port = 587;                   // set the SMTP port for the GMAIL server
//        Yii::app()->mailer->Username = "mytashpmi@gmail.com";  // GMAIL username
//        Yii::app()->mailer->Password = "147896325tashpmi";            // GMAIL password
);
