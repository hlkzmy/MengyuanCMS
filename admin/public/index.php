<?php

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('PRC');

chdir(dirname(__DIR__));

define('BASEPATH', dirname(__DIR__));

define('WEBSITE_DISK_PATH', dirname(dirname(__DIR__)));

define('VIDEO_DISK_PATH', dirname(dirname(__DIR__)).'/media/video/');

define('COURSEWARE_DISK_PATH', dirname(dirname(__DIR__)).'/media/courseware/');

define('CERTIFICATE_DISK_PATH', dirname(dirname(__DIR__)).'/media/certificate/');

define('TEMP_DISK_PATH', dirname(dirname(__DIR__)).'/media/temp/');

define('FFMPEG_DISK_PATH', dirname(dirname(__DIR__)).'/tools/Ffmpeg/');



define('PROJECT_NAME', '后台');

define('VERSIONS', '2.2.1');


// Setup autoloading
require 'init_autoloader.php';
// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();