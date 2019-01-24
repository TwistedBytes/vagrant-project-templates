<?php
global $databaseConfig;
$database_info = parse_ini_file($_SERVER["HOME"] . '/private/databases.ini', true);
$database_config = array_shift($database_info);

define('SS_ENVIRONMENT_TYPE', 'dev');

/* Database connection */
define('SS_DATABASE_CLASS', "MySQLPDODatabase");
define('SS_DATABASE_SERVER', $database_config['hostname']);
define('SS_DATABASE_USERNAME', $database_config['username']);
define('SS_DATABASE_PASSWORD', $database_config['password']);
define('SS_DATABASE_NAME', $database_config['database']);

/* Configure a default username and password to access the CMS on all sites in this environment. */
define('SS_DEFAULT_ADMIN_USERNAME', 'admin');
define('SS_DEFAULT_ADMIN_PASSWORD', 'admin');

unset($database_info);
unset($database_config);

global $_FILE_TO_URL_MAPPING;
# define('BASE_PATH', $_SERVER['HOME'].'/site/docroot');
$_FILE_TO_URL_MAPPING ['/data/site/docroot'] = 'http://silverstripe-37.tbdev.xyz';
