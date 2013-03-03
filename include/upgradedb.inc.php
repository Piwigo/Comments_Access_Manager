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
  
  $Newconf_CM['CMVersion'] = $version;
  
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


/* upgrade from 2.2.0 to 2.2.1 */
/* *************************** */
function upgradeCM_220_221()
{
  global $conf;

  // Upgrading options
  $query = '
SELECT value
  FROM '.CONFIG_TABLE.'
WHERE param = "CommentsManager"
;';

  $result = pwg_query($query);
  $conf_CM = pwg_db_fetch_assoc($result);
    
  $Newconf_CM = unserialize($conf_CM['value']);
  
  $Newconf_CM[4] = 'false';
  $Newconf_CM[5] = '-1';
  
  $update_conf = serialize($Newconf_CM);

  conf_update_param('CommentsManager', pwg_db_real_escape_string($update_conf));
}


/* upgrade from 2.2.1 to 2.2.2 */
/* *************************** */
function upgradeCM_221_222()
{
  global $conf;

  // Upgrading options
  $query = '
SELECT value
  FROM '.CONFIG_TABLE.'
WHERE param = "CommentsManager"
;';

  $result = pwg_query($query);
  $conf_CM = pwg_db_fetch_assoc($result);
    
  $Newconf_CM = unserialize($conf_CM['value']);
  
  $Newconf_CM[6] = 'false';
  $Newconf_CM[7] = '-1';
  
  $update_conf = serialize($Newconf_CM);

  conf_update_param('CommentsManager', pwg_db_real_escape_string($update_conf));
}


/* upgrade from 2.4 to 2.5 */
/* *********************** */
function upgradeCM_240_250()
{
  global $conf;

  // Upgrading options - Changing config variables to assoc array
  // ------------------------------------------------------------
  
  // Upgrade $conf_CM options
  $conf_CM = unserialize($conf['CommentsManager']);

  $Newconf_CM = array(
    'CMVersion'               => $conf_CM[0],
    'CM_No_Comment_Anonymous' => $conf_CM[1],
    'CM_GROUPCOMM'            => $conf_CM[2],
    'CM_ALLOWCOMM_GROUP'      => $conf_CM[3],
    'CM_GROUPVALID1'          => $conf_CM[4],
    'CM_VALIDCOMM1_GROUP'     => $conf_CM[5],
    'CM_GROUPVALID2'          => $conf_CM[6],
    'CM_VALIDCOMM2_GROUP'     => $conf_CM[7]
  );

  // unset obsolete conf
  // -------------------
  for ($i = 0; $i <= 7; $i++)
  {
    unset ($conf_CM[$i]);
  }

  $update_conf = serialize($Newconf_CM);

  conf_update_param('CommentsManager', pwg_db_real_escape_string($update_conf));
}
?>