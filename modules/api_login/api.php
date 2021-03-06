<?php

/**
 * @package modules
 * @subpackage api_login
 */

/* Constants */
define('DEBUG_MODE', false);
define('APP_PATH', dirname(dirname(dirname(__FILE__))).'/');
define('CONFIG_FILE', APP_PATH.'hm3.rc');

/* Init the framework */
require_once APP_PATH.'lib/framework.php';
require APP_PATH.'modules/core/functions.php';

/**
 * Start a user session if the user/pass are valid
 * @subpackage api_login/functions
 * @param string $user username
 * @param string $pass password
 * @param string $url location of the Cypht installation
 * @return bool
 */
function cypht_login($user, $pass, $url, $lifetime=0) {
    list($session, $request) = session_init();
    $session->check($request, $user, $pass, false);
    if ($session->is_active()) {
        list($domain, $path, $secure) = url_parse($url);
        $config = new Hm_Site_Config_File(CONFIG_FILE);
        $user_config = load_user_config_object($config);
        $user_config->load($user, $pass);
        $user_data = $user_config->dump();
        $session->set('user_data', $user_data);
        Hm_Functions::setcookie('hm_id', stripslashes($session->enc_key), $lifetime, $path, $domain, $secure, true);
        Hm_Functions::setcookie('hm_session', stripslashes($session->session_key), $lifetime, $path, $domain, $secure, true);
        $session->end();
        return true;
    }
    return false;
}

/**
 * Log a user out of cypht
 * @subpackage api_login/functions
 * @return void
 */
function cypht_logout($url) {
    list($session, $request) = session_init();
    list($domain, $path, $secure) = url_parse($url);
    $session->delete_cookie($request, 'hm_id', $path, $domain);
    $session->delete_cookie($request, 'hm_session', $path, $domain);
}

/**
 * Parse URL
 * @subpackage api_login/functions
 * @param string $url location of the Cypht installation
 * @return array
 */
function url_parse($url) {
    $parsed = parse_url($url);
    $secure = $parsed['scheme'] === 'https' ? true : false;
    return array($parsed['host'], $parsed['path'], $secure);
}

/**
 * Startup the session and request objects
 * @subpackage api_login/functions
 * @return array
 */
function session_init() {
    $config = new Hm_Site_Config_File(APP_PATH.'hm3.rc');
    $module_exec = new Hm_Module_Exec($config);
    $request = new Hm_Request($module_exec->filters, $config);
    $session_config = new Hm_Session_Setup($config);
    $session = $session_config->setup_session();
    return array($session, $request);
}
