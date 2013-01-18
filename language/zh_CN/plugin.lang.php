<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2012 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+
$lang['CM_Validation_For_Group'] = '管理员评论无需审核';
$lang['CM_No_Anonymous_Comments'] = '未注册用户必须填写昵称';
$lang['CM_Support_txt'] = 'Piwigo 论坛的此主题为本插件的唯一官方支持:<br>
<a href="http://piwigo.org/forum/viewtopic.php?id=17577" onclick="window.open(this.href);return false;">English forum - http://piwigo.org/forum/viewtopic.php?id=17577</a><br><br>
以及本项目的 bugtracker: <a href="http://piwigo.org/bugs/" onclick="window.open(this.href);return false;">http://piwigo.org/bugs/</a>';
$lang['CM_AllowedComm_Group'] = '选择允许评论的用户组：';
$lang['CM_CommentsForAll'] = '"允许所有人评论"已<b style="color:red;">启用</b>';
$lang['CM_CommentsForRegistered'] = '"允许所有人评论"已<b style="color:red;">禁用</b>';
$lang['CM_CommentsValidationOff'] = '"评论审核"已<b style="color:red;">禁用</b>';
$lang['CM_CommentsValidationOn'] = '"评论审核"已<b style="color:red;">启用</b>';
$lang['CM_Comments_For_Group'] = '对某一组用户允许评论';
$lang['CM_Disable'] = '禁用（默认）';
$lang['CM_Empty Author'] = '评论人昵称为必填项！';
$lang['CM_Enable'] = '启用';
$lang['CM_Not_Allowed_Author'] = '抱歉，您未被允许发表评论，请与站长联系。';
$lang['CM_SubTitle'] = '插件设置';
$lang['CM_Title'] = 'Comments Access Manager - 版本：';
$lang['CM_ValidComm_Group'] = '选择允许评论且无需审核的用户组：';
$lang['CM_save_config'] = '设置已保存！';
$lang['CM_submit'] = '保存设置';
$lang['CM_commentTitle_d'] = '如果 <b>&quot;允许所有人评论&quot;</b> 被启用 （授权未注册的访客发布评论），本选项将要求未注册的访客在发布评论时填写一个昵称。';
$lang['CM_ValidCommTitle_d'] = '本选项使您能够指定一组用户，当 <u>允许所有人评论</u> 被禁用且评论需要管理员审核时，允许他们的评论不须管理员审核即可发布。
<br><br>
根据默认设置，当 <b>&quot;允许所有人评论&quot;</b> 被禁用且评论审核功能被启用时，注册用户发布的评论在被相册显示前，将提交管理员进行审核。而通过本选项，您可以选定某一组的注册用户，允许他们的评论无需预先通过审核就能发布。';
$lang['CM_GroupCommTitle_d'] = '当 允许所有人评论 被禁用时，本选项使您能够指定一组用户，允许他们发布评论。
<br><br>
根据默认设置，当 <b>&quot;允许所有人评论&quot;</b> 选项被禁用时，仅注册用户可以发布评论。而通过本选项，您可以通过指定用户组的方式对此规则作出进一步限定。即只有注册用户并且属于某个组的用户方可发布评论。';
$lang['CM_commentTitle'] = '未注册用户必须填写昵称';
$lang['CM_ValidCommTitle'] = '允许不经管理员审核即可发布评论';
$lang['CM_ValidComm2Title_d'] = '本选项使您能够指定一组用户，当相册被设置为 <u>允许所有人评论</u> 且评论需要管理员审核时，允许他们的评论不须管理员审核即可发布。
<br><br>
根据默认设置，当 <b>&quot;允许所有人评论&quot;</b> 和评论审核功能被启用时，注册用户发布的评论在被相册显示前，将提交管理员进行审核。而通过本选项，您可以选定某一组的注册用户，允许他们的评论无需预先通过审核就能发布。';
$lang['CM_CommentsValidationOffTitle'] = '&quot;评论审核&quot; 已禁用';
$lang['CM_CommentsValidationOffTitle_d'] = '启用本选项，以在此查看更多参数。';
$lang['CM_GroupCommTitle'] = '向某一组用户开放评论';
?>