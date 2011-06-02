<?php
load_language('plugin.lang', CM_PATH);


/**
 * Triggered on get_admin_plugin_menu_links
 * 
 * Plugin's administration menu 
 */
function CM_admin_menu($menu)
{
// +-----------------------------------------------------------------------+
// |                      Getting plugin name                              |
// +-----------------------------------------------------------------------+
  $plugin =  CM_Infos(CM_PATH);
  $name = $plugin['name'];
  
  array_push($menu,
    array(
      'NAME' => $name,
      'URL' => get_root_url().'admin.php?page=plugin-'.basename(CM_PATH)
    )
  );

  return $menu;
}


/**
 * Check comment rules set in plugin before accepting it
 *
 * @param : comment action, comment
 * 
 * @return : comment action
 * 
 */
function CM_CheckComment($comment_action, $comm)
{
  load_language('plugin.lang', CM_PATH);
  global $infos, $conf, $user;

  $conf_CM = unserialize($conf['CommentsManager']);

  if ($conf['comments_forall'])
  {
    // Does not allow empty author name on comments for all
    if ((isset($conf_CM[1]) and $conf_CM[1] == 'true') and $comm['author'] == 'guest')
    {
      $comment_action = 'reject';

      array_push($infos, l10n('CM_Empty Author'));
    }
    
    if ((isset($conf_CM[6]) and $conf_CM[6] == 'true') and !is_a_guest() and $conf['comments_validation'])
    {
      if (CM_CheckValidGroup($comm['author']) or is_admin())
      {
        $comment_action = 'validate'; // Comment is validated if author is not in the validated group
      }
      else
      {
        $comment_action = 'moderate'; // Comment needs moderation if author is not in the validated group
      }
    }
  }

// Rules on comments NOT for all
  if (!$conf['comments_forall'] and !is_admin())
  {
    if ((isset($conf_CM[2]) and $conf_CM[2] == 'true') and (isset($conf_CM[4]) and $conf_CM[4] == 'false') and !CM_CheckAuthor($comm['author'])) // Comments authorized group set - Auto validation group unset 
    {
      $comment_action = 'reject'; // Comment rejected if author is not in the allowed group
      array_push($infos, l10n('CM_Not_Allowed_Author'));
    }
    elseif ((isset($conf_CM[2]) and $conf_CM[2] == 'false') and (isset($conf_CM[4]) and $conf_CM[4] == 'true') and $conf['comments_validation']) // Comments authorized group unset - Auto validation group set
    {
      if (CM_CheckValidGroup($comm['author']) and $conf['comments_validation'])
      {
        $comment_action = 'validate'; // Comment is validated if author is not in the validated group
      }
      else
      {
        $comment_action = 'moderate'; // Comment needs moderation if author is not in the validated group
      }
    }
    elseif ((isset($conf_CM[2]) and $conf_CM[2] == 'true') and (isset($conf_CM[4]) and $conf_CM[4] == 'true') and $conf['comments_validation']) // Comments authorized group set - Auto validation group set
    {
      if (!CM_CheckAuthor($comm['author']))
      {
        $comment_action = 'reject'; // Comment rejected if author is not in the allowed group
        array_push($infos, l10n('CM_Not_Allowed_Author'));
      }
      elseif (CM_CheckValidGroup($comm['author']) and $conf['comments_validation'])
      {
        $comment_action = 'validate'; // Comment is validated if author is not in the validated group
      }
      else
        $comment_action = 'moderate'; // Comment needs moderation if author is not in the validated group
    }
  }

  return $comment_action;
}


/**
 * Checks if comment's author name is in the allowed group
 * 
 * @author   : author's name
 * 
 * @returns  : Boolean (true is user is allowed to post / false if not allowed)
 * 
 */
function CM_CheckAuthor($author)
{
  global $conf;
  
	// Get CM configuration
  $conf_CM = unserialize($conf['CommentsManager']);
  
  if (isset($conf_CM[3]) and $conf_CM[3] <> -1)
  {
    $query = '
SELECT u.id,
       u.username,
       ug.user_id,
       ug.group_id
FROM '.USERS_TABLE.' AS u
  INNER JOIN '.USER_GROUP_TABLE.' AS ug
    ON u.id = ug.user_id
WHERE u.username LIKE "'.$author.'"
  AND ug.group_id = '.$conf_CM[3].'
;';

    $count = pwg_db_num_rows(pwg_query($query));

    if (is_null($count) or $count == 0)
    {
      return false;
    }
    else
      return true;
  }
}


/**
 * Checks if comment's author name is in the admin's pre-validated group
 * avoid admins to validate comments for the members of this group
 * 
 * @author   : author's name
 * 
 * @returns  : Boolean (true if user's comment doesn't need validation / false if user's comment is moderated)
 * 
 */
function CM_CheckValidGroup($author)
{
  global $conf;
  
	// Get CM configuration
  $conf_CM = unserialize($conf['CommentsManager']);
  
  if ($conf['comments_forall'])
  {
    if (isset($conf_CM[7]) and $conf_CM[7] <> -1)
    {
      $group_id = $conf_CM[7];
    }
  }
  else
  {
    if (isset($conf_CM[5]) and $conf_CM[5] <> -1)
    {
      $group_id = $conf_CM[5];
    }
  }

  $query = '
SELECT u.id,
       u.username,
       ug.user_id,
       ug.group_id
FROM '.USERS_TABLE.' AS u
  INNER JOIN '.USER_GROUP_TABLE.' AS ug
    ON u.id = ug.user_id
WHERE u.username LIKE "'.$author.'"
  AND ug.group_id = '.$group_id.'
;';

  $count = pwg_db_num_rows(pwg_query($query));

  if (is_null($count) or $count == 0)
  {
    return false;
  }
  else
    return true;
}


/**
 * Get the plugin version and name
 *
 * @param : plugin directory
 * 
 * @return : plugin's version and name
 * 
 */
function CM_Infos($dir)
{
  $path = $dir;

  $plg_data = implode( '', file($path.'main.inc.php') );
  if ( preg_match("|Plugin Name: (.*)|", $plg_data, $val) )
  {
    $plugin['name'] = trim( $val[1] );
  }
  if (preg_match("|Version: (.*)|", $plg_data, $val))
  {
    $plugin['version'] = trim($val[1]);
  }
  if ( preg_match("|Plugin URI: (.*)|", $plg_data, $val) )
  {
    $plugin['uri'] = trim($val[1]);
  }
  if ($desc = load_language('description.txt', $path.'/', array('return' => true)))
  {
    $plugin['description'] = trim($desc);
  }
  elseif ( preg_match("|Description: (.*)|", $plg_data, $val) )
  {
    $plugin['description'] = trim($val[1]);
  }
  if ( preg_match("|Author: (.*)|", $plg_data, $val) )
  {
    $plugin['author'] = trim($val[1]);
  }
  if ( preg_match("|Author URI: (.*)|", $plg_data, $val) )
  {
    $plugin['author uri'] = trim($val[1]);
  }
  if (!empty($plugin['uri']) and strpos($plugin['uri'] , 'extension_view.php?eid='))
  {
    list( , $extension) = explode('extension_view.php?eid=', $plugin['uri']);
    if (is_numeric($extension)) $plugin['extension'] = $extension;
  }
// IMPORTANT SECURITY !
  $plugin = array_map('htmlspecialchars', $plugin);

  return $plugin ;
}


/**
 * Delete obsolete files on plugin upgrade
 * Obsolete files are listed in file obsolete.list
 *
 */
function CM_Obsolete_Files()
{
  if (file_exists(CM_PATH.'obsolete.list')
    and $old_files = file(CM_PATH.'obsolete.list', FILE_IGNORE_NEW_LINES)
    and !empty($old_files))
  {
    array_push($old_files, 'obsolete.list');
    foreach($old_files as $old_file)
    {
      $path = CM_PATH.$old_file;
      if (is_file($path))
      {
        @unlink($path);
      }
    }
  }
}
?>