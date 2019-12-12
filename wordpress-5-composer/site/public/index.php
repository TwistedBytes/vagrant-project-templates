<?php

require_once(dirname(__DIR__) . '/vendor/autoload.php');

// WordPress view bootstrapper
define('WP_USE_THEMES', true);
$_SERVER['SERVER_ADMIN'] = false;
require(__DIR__ . '/wp/wp-blog-header.php');
