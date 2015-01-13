<?php
date_default_timezone_set('UTC');

require(dirname(__FILE__) . '/../framework/yiilite.php');

$config = require(dirname(__FILE__) . '/../application/config/params.php');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

$app = Yii::createWebApplication($config)->run();
