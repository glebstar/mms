<?php

// загружаем конфиги
require_once ROOT_DIR . '/cfg/config.php';

error_reporting($mainCfg['error_level']);
ini_set('display_errors', $mainCfg['display_errors']);

require_once ROOT_DIR . '/lib/func.php';
