<?php

global $lang, $conf, $errors;

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok                      |
// +-----------------------------------------------------------------------+
check_status(ACCESS_ADMINISTRATOR);

if (!defined('CM_PATH')) define('CM_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

include_once (PHPWG_ROOT_PATH.'/include/constants.php');

load_language('plugin.lang', CM_PATH);
load_language('help.lang', CM_PATH);


// +-----------------------------------------------------------------------+
// |                      Getting plugin version                           |
// +-----------------------------------------------------------------------+
$plugin =  CM_Infos(CM_PATH);
$version = $plugin['version'];


// *************************************************************************
// +-----------------------------------------------------------------------+
// |                           Plugin Config                               |
// +-----------------------------------------------------------------------+
// *************************************************************************

	if (isset($_POST['submit']) and isset($_POST['CM_No_Comment_Anonymous']) and isset($_POST['CM_GroupComm']) and isset($_POST['CM_GroupValid1']) and isset($_POST['CM_GroupValid2']))
  {

		$newconf_CM = array(
      $version,
      $_POST['CM_No_Comment_Anonymous'],
      $_POST['CM_GroupComm'],
      (isset($_POST['CM_AllowComm_Group'])?$_POST['CM_AllowComm_Group']:''),
      $_POST['CM_GroupValid1'],
      (isset($_POST['CM_ValidComm_Group1'])?$_POST['CM_ValidComm_Group1']:''),
      $_POST['CM_GroupValid2'],
      (isset($_POST['CM_ValidComm_Group2'])?$_POST['CM_ValidComm_Group2']:''),
      );

    $conf['CommentsManager'] = serialize($newconf_CM);

    conf_update_param('CommentsManager', pwg_db_real_escape_string($conf['CommentsManager']));

		array_push($page['infos'], l10n('CM_save_config'));
  }

  $conf_CM = unserialize($conf['CommentsManager']);


  //Group setting
  $groups[-1] = '---------';
  $AllowComm = -1;
  $ValidComm1 = -1;
  $ValidComm2 = -1;
	
  //Check groups list in database 
  $query = '
SELECT id, name
FROM '.GROUPS_TABLE.'
ORDER BY name ASC
;';
	
  $result = pwg_query($query);
	
  while ($row = pwg_db_fetch_assoc($result))
  {
    $groups[$row['id']] = $row['name'];

    //configuration value for users group allowed to post comments
    if (isset($conf_CM[3]) and $conf_CM[3] == $row['id'])
		{
	  	$AllowComm = $row['id'];
		}

    //configuration value for users group allowed to post comments
    if (isset($conf_CM[5]) and $conf_CM[5] == $row['id'])
		{
	  	$ValidComm1 = $row['id'];
		}

    //configuration value for users group allowed to post comments
    if (isset($conf_CM[7]) and $conf_CM[7] == $row['id'])
		{
	  	$ValidComm2 = $row['id'];
		}
  }

  //Template initialization for allowed group for comments
  $template->assign(
    'AllowComm_Group',
		array(
      'group_options'=> $groups,
      'group_selected' => $AllowComm
			)
  	);
  //Template initialization for validated group for comments
  $template->assign(
    'ValidComm_Group1',
		array(
      'group_options'=> $groups,
      'group_selected' => $ValidComm1
			)
  	);
  //Template initialization for validated group for comments
  $template->assign(
    'ValidComm_Group2',
		array(
      'group_options'=> $groups,
      'group_selected' => $ValidComm2
			)
  	);


  // Template initialization for forms and data
  $themeconf=$template->get_template_vars('themeconf');
  $CM_theme=$themeconf['id'];

  $template->assign(
    array(
    'CM_PATH'                       => CM_PATH,
    'CM_CFA'                        => $conf['comments_forall'],
    'CM_VALIDATION'                 => $conf['comments_validation'],
    'CM_VERSION'                    => $conf_CM[0],
		'CM_NO_COMMENT_ANO_TRUE'        => $conf_CM[1]=='true' ?  'checked="checked"' : '' ,
		'CM_NO_COMMENT_ANO_FALSE'       => $conf_CM[1]=='false' ?  'checked="checked"' : '' ,
    'CM_GROUPCOMM_TRUE'             => $conf_CM[2]=='true' ?  'checked="checked"' : '' ,
    'CM_GROUPCOMM_FALSE'            => $conf_CM[2]=='false' ?  'checked="checked"' : '' ,
    'CM_ALLOWCOMM_GROUP'            => $conf_CM[3],
    'CM_GROUPVALID1_TRUE'           => $conf_CM[4]=='true' ?  'checked="checked"' : '' ,
    'CM_GROUPVALID1_FALSE'          => $conf_CM[4]=='false' ?  'checked="checked"' : '' ,
    'CM_VALIDCOMM1_GROUP'           => $conf_CM[5],
    'CM_GROUPVALID2_TRUE'           => $conf_CM[6]=='true' ?  'checked="checked"' : '' ,
    'CM_GROUPVALID2_FALSE'          => $conf_CM[6]=='false' ?  'checked="checked"' : '' ,
    'CM_VALIDCOMM2_GROUP'           => $conf_CM[7],
    )
  );


// +-----------------------------------------------------------------------+
// |                             errors display                            |
// +-----------------------------------------------------------------------+
  if (isset ($errors) and count($errors) != 0)
  {
	  $template->assign('errors',array());
	  foreach ($errors as $error)
	  {
		  array_push($page['errors'], $error);
		}
	}

// +-----------------------------------------------------------------------+
// |                           templates display                           |
// +-----------------------------------------------------------------------+
  $template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/admin.tpl');
  $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>