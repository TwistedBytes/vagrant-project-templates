<?php

use Dotenv\Dotenv;

$root_dir = dirname(__DIR__);
$webroot_dir = $root_dir . '/public';

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */

if (file_exists($root_dir . '/.env')) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}

/**
 * Set up our global environment constant and load its config first
 * Default: development
 */
define('WP_ENV', getenv('WP_ENV') ?: 'development');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

/**
 * URLs
 */
define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', $webroot_dir . '/content');
define('WP_CONTENT_DIR', CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . '/content');

/**
 * DB settings
 */
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = getenv('DB_PREFIX') ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY', getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', getenv('LOGGED_IN_KEY'));
define('NONCE_KEY', getenv('NONCE_KEY'));
define('AUTH_SALT', getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', getenv('LOGGED_IN_SALT'));
define('NONCE_SALT', getenv('NONCE_SALT'));

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', getenv('DISABLE_WP_CRON') ?: false);
define('DISALLOW_FILE_EDIT', true);
define('WP_MEMORY_LIMIT', '1024M');

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}

if (false) {

    ErrorHandler::enable();
    spl_autoload_unregister([Autoloader::class, 'lazyRegister']);
    if (isset($_SERVER['SERVER_NAME'])) { // A web request?
        $url = Url::getCurrentURL();
        $homeUrl = new Url(WP_HOME);
        $relUrl = str_replace($homeUrl->path, '', $url->path);
        if (preg_match('/^\/thumbs\//', $relUrl)) { // Generate a thumbnail?
            $memory_limit = 512;
            if (substr(ini_get('memory_limit'), -1) === 'M' && floor(ini_get('memory_limit')) < $memory_limit) {
                ini_set('memory_limit', $memory_limit . 'M');
            }
            Image::handleRequest($relUrl);
        }
        if (preg_match('/^\/app\/uploads\/(?<path>.+)_(?<width>[0-9]+)x(?<height>[0-9]+)\.(?<ext>jpg|png|gif)$/', $relUrl, $match)) {
            $thumbUrl = 'thumbs/' . $match['width'] . 'x' . $match['height'] . '/' . $match['path'] . '.' . $match['ext'];
            $thumbFile = WP_CONTENT_DIR . '/../' . $thumbUrl;
            if (file_exists($thumbFile)) {
                \Sledgehammer\render_file($thumbFile);
            }
            Sledgehammer\redirect(WP_HOME . '/' . $thumbUrl);
        }
    }
// Configure Autowereld API
    Autowereld::$instances['default'] = new Autowereld('bd4ed0f1800d6ddd3405');
// Configure Autotelex
    Connection::$instances['autotelex'] = function () {
        $db = new Connection(getenv('AUTOTELEX_DB'));
        $index = array_search($db->logger, Logger::$instances);
        unset(Logger::$instances[$index]);
        Logger::$instances['Database[autotelex]'] = $db->logger;
        return $db;
    };
    Repository::configureDefault(function ($repo) {
        $repo->registerBackend(new AutotelexRepositoryBackend());
    });
}