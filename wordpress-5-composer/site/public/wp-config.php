<?php
require_once(dirname(__DIR__) . '/vendor/autoload.php');
require_once(dirname(__DIR__) . '/config/application.php');

define('WP_CACHE', false);
define('WPCACHEHOME', '/data/site/public/content/plugins/wp-super-cache/');

require_once(ABSPATH . 'wp-settings.php');

// Enable WP_DEBUG mode
define('WP_DEBUG', false);
