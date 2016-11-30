<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Keypoint',
    'sourceLanguage' => 'en_US',
    'language' => 'en',
    'defaultController' => 'site',
    'charset' => 'UTF-8',
    'preload' => array('log'),
    'theme' => 'classic',
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.YiiMailer.YiiMailer',
    ),
    'modules' => array(
        'admin',
        'customer',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'm500',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    'components' => array(
        'widgetFactory' => array(
            'widgets' => array(
                'CGridView' => array(
                    'htmlOptions' => array(
                        'class' => 'table-responsive',
                    ),
                    'itemsCssClass' => 'table table-striped table-bordered table-hover dataTable no-footer',
                    'cssFile' => false,
                ),
                'CDetailView' => array(
                    'htmlOptions' => array(
                        'class' => 'table table-striped',
                    ),
                    'cssFile' => false,
                ),
                'CLinkPager' => array(
                    'header' => '',
                    'htmlOptions' => array(
                        'class' => 'pagination',
                        'ajaxUpdate' => false,
                    ),
                    'cssFile' => false,
                    'firstPageLabel' => '<i class="fa fa-fast-backward"></i>',
                    'prevPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                    'nextPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                    'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
                    'selectedPageCssClass' => 'active',
                ),
            ),
        ),
        'clientScript' => array(
            'packages' => array(
                'jquery' => array(
                    'baseUrl' => '/bower_components/jquery/dist/',
                    'js' => array('jquery.min.js'),
                )
            ),
        ),
        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),
        'user' => array(
            'loginUrl' => array('login/index'),
            'allowAutoLogin' => true,
            'class' => 'WebUser',
        ),
        'phpThumb' => array(
            'class' => 'ext.EPhpThumb.EPhpThumb.EPhpThumb',
        ),
        'urlManager' => array(
            'class' => 'ext.yii-multilanguage.MLUrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            'languages' => array(
                'en',
                'sv',
                'no',
                'da',
                'fi',
                'de',
            ),
            'rules' => array(
                //
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //   
                '<module:\w+>/<controller:\w+>/<id:\d+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>',
                '<module:\w+>' => '<module>',
                //
                '/' => 'site/index',
                'login' => 'login/index',
            ),
        ),
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            'errorAction' => 'error/index',
        ),
//        'log' => array(
//            'class' => 'CLogRouter',
//            'routes' => array(
//                array(
//                    'class' => 'CFileLogRoute',
//                    'levels' => 'trace,log',
//                    'categories' => 'system.db.CDbCommand',
//                    'logFile' => 'db.log',
//                ),
//            ),
//        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => 'webmaster@example.com',
    ),
);
