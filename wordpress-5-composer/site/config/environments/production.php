<?php


//define( 'WP_DEBUG_LOG', true );
define('WP_DEBUG', false);

/* Production */
//ini_set('display_errors', 0);
error_reporting(E_ERROR);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG',false); // allows plugin installation
define('DISALLOW_FILE_MODS', false); // this disables all file modifications including updates and update notifications

