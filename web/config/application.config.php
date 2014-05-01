<?php
return array(
    'modules' => array(
        'Application',
    	'Help'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        	'config/autoload/db.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
