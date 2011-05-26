<?php

if(!defined('CM_PATH'))
{
  define('CM_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
}

include_once (CM_PATH.'include/functions.inc.php');

function plugin_install()
{
	global $conf;
  
  // Set current plugin version in config table
  $plugin =  CM_Infos(CM_PATH);
  $version = $plugin['version'];
	
  $default = array($version,'false','false',-1,'false',-1);

	$query = '
SELECT param
  FROM '.CONFIG_TABLE.'
WHERE param = "CommentsManager"
;';
  $count = pwg_db_num_rows(pwg_query($query));
  
  if ($count == 0)
  {
    $q = '
INSERT INTO '.CONFIG_TABLE.' (param, value, comment)
VALUES ("CommentsManager","'.pwg_db_real_escape_string(serialize($default)).'","Comments Access Manager parameters")
  ;';
    pwg_query($q);
  }
}


function plugin_activate()
{
  global $conf;

/* Cleaning obsolete files */
/* *********************** */
  CM_Obsolete_Files();
  
  include_once (CM_PATH.'include/upgradedb.inc.php');

  // Database upgrade process
  if (isset($conf['CommentsManager']))
  {
    $conf_CM = unserialize($conf['CommentsManager']);
    
    // upgrade from 2.2.0 to 2.2.1
    if (version_compare($conf_CM[0], '2.2.1') < 0)
    {
      upgradeCM_220_221();
    }
  }
  
  // Update plugin version number in #_config table and check consistency of #_plugins table
  CM_version_update();

  load_conf_from_db('param like \'CommentsManager\'');
}


function plugin_uninstall()
{
  global $conf;

  if (isset($conf['CommentsManager']))
  {
    $q = '
DELETE FROM '.CONFIG_TABLE.'
WHERE param="CommentsManager"
;';

    pwg_query($q);
  }
}
?>