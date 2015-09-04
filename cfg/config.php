<?php

$mainCfg = array(
    'db' => array(
        'dbname'    => 'mms',
        'host'      => '127.0.0.1',
        'user'      => 'mms',
        'password'  => 'mms'
    ),
    'error_level'     => E_ALL,
    'display_errors'  => 'Off',
    'script_version'  => 1
);

if (file_exists(ROOT_DIR . '/cfg/config.local.php')) {
    require_once ROOT_DIR . '/cfg/config.local.php';
}
