<?php

ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true); // allows plugin installation
define('DISALLOW_FILE_MODS', false);
define('SAVEQUERIES', isset($_GET['debug']) ? (bool) $_GET['debug'] : false);
