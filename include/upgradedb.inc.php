<?php
/**
 * @author Eric@piwigo.org
 *  
 * Upgrade processes for old plugin version
 * Called from maintain.inc.php on plugin activation
 * 
 */

if(!defined('CM_PATH'))
{
  define('CM_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
}

include_once (CM_PATH.'include/functions.inc.php');

// +----------------------------------------------------------+
// |       Upgrading database from old plugin versions        |
// +----------------------------------------------------------+


/* *************************************** */
/* Update plugin version in conf table     */
/* Used everytime a new version is updated */
/* even if no database upgrade is needed   */
/* *************************************** */
function CM_version_update()
{
  global $conf;
  
  // Get current plugin version
  $plugin =  CM_Infos(CM_PATH);
  $version = $plugin['version'];

  // Upgrading options
  $query = '
SELECT value
  FROM '.CONFIG_TABLE.'
WHERE param = "CommentsManager"
;';

  $result = pwg_query($query);
  $conf_CM = pwg_db_fetch_assoc($result);
    
  $Newconf_CM = unserialize($conf_CM['value']);
  
  $Newconf_CM[0] = $version;
  
  $update_conf = serialize($Newconf_CM);

  conf_update_param('CommentsManager', pwg_db_real_escape_string($update_conf));


// Check #_plugin table consistency
// Only useful if a previous version upgrade has not worked correctly (rare case)
  $query = '
SELECT version
  FROM '.PLUGINS_TABLE.'
WHERE id = "CommentsManager"
;';
  
  $data = pwg_db_fetch_assoc(pwg_query($query));
  
  if (empty($data['version']) or $data['version'] <> $version)
  {
    $query = '
UPDATE '.PLUGINS_TABLE.'
SET version="'.$version.'"
WHERE id = "CommentsManager"
LIMIT 1
;';

    pwg_query($query);
  }
}
?>