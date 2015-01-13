<?php
Yii::setPathOfAlias('site', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
Yii::setPathOfAlias('widgets', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'widgets');

$config = array(

    'basePath'    => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'runtimePath' => '/tmp',
    'preload' => array('log'),

    'import'      => array(
        'site.models.*',
        'site.components.*',
        'site.components.widgets.*',
        'site.controllers.*',
    ),

    // application components
    'components'  => array(
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CWebLogRoute',
                ),
            ),
        ),
        'user' => array(
            'class'  => 'WebUser',
            'allowAutoLogin' => true,
            'autoRenewCookie' => true,
        ),
        'urlManager' => array(
            'urlFormat'      => 'path',
            'showScriptName' => false,
            'rules'          => array(
                '' => 'site/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            )
        ),
        'cache' => array(
            'class' => 'site.extensions.cache.RedisCache',
            'servers' => array('127.0.0.1:63790', '127.0.0.1:63791'),
        ),
        'db'         => array(
            'class'                 => 'CDbConnection',
            'connectionString'      => 'mysql:host=127.0.0.1;port=3306;dbname=mytest',
            'emulatePrepare'        => true,
            'autoConnect'           => false,
            'username'              => 'root',
            'password'              => 'DevMySQL',
            'charset'               => 'utf8',
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'      => array(
        'messagesLimit' => 50, // Обший лимит сообщений на странице
        'oldMessages' => 10, // Кол-во старых сообщений
        'oldMessagesSymbols' => 5, // Кол-во выводимых символов в старых сообщениях
    ),
);

return $config;
