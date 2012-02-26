<?php
/*
Plugin Name: Comments Access Manager
Version: 2.3.4
Description: Gérer l'accès aux commentaites - Manage comments access
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=545
Author: Eric
Author URI: http://www.infernoweb.net
*/

/* History:  CM_PATH.'Changelog.txt' */

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
if (!defined('CM_PATH')) define('CM_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

global $conf;

include_once (CM_PATH.'include/functions.inc.php');

// Plugin administration panel
add_event_handler('get_admin_plugin_menu_links', 'CM_admin_menu');

// Comments authorisation check
add_event_handler('user_comment_check', 'CM_CheckComment', 50, 2);
?>