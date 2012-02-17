{combine_script id='jquery' path='themes/default/js/jquery.min.js'}
{combine_script id='jquery.cluetip' require='jquery' path='themes/default/js/plugins/jquery.cluetip.js'}

{combine_css path= $CM_PATH|@cat:'template/cm.css'}

<script type="text/javascript">
jQuery().ready(function()
{ldelim}
  jQuery('.cluetip').cluetip(
  {ldelim}
    width: 500,
    splitTitle: '|'
  {rdelim});
{rdelim});
</script>

<div class="titrePage">
  <h2>{'CM_Title'|@translate} {$CM_VERSION}<br>{'CM_SubTitle'|@translate}</h2>
</div>

<form method="post" action="" class="general">

  <p>
    <input class="submit" type="submit" value="{'CM_submit'|@translate}" name="submit" {$TAG_INPUT_ENABLED}>
  </p>

  <fieldset>

  {if !$CM_CFA}
    <div class="cm_hide">
  {/if}
      <fieldset>
        <div class="FieldTitle">
          {'CM_CommentsForAll'|@translate}
        </div>

        <br>

        <ul>
          <li>
            <label class="cluetip" title="{'CM_commentTitle'|translate}|{'CM_commentTitle_d'|translate}">
              {'CM_No_Anonymous_Comments'|@translate}
            </label>

          <br><br>

            <input type="radio" value="false" {$CM_NO_COMMENT_ANO_FALSE} name="CM_No_Comment_Anonymous">
              {'CM_Disable'|@translate}
        
          <br>

            <input type="radio" value="true" {$CM_NO_COMMENT_ANO_TRUE} name="CM_No_Comment_Anonymous">
              {'CM_Enable'|@translate}

          </li>

        {if !$CM_VALIDATION}
          <div class="FieldTitle">
            <p class="cluetip" title="{'CM_CommentsValidationOffTitle'|translate}|{'CM_CommentsValidationOffTitle_d'|translate}">
              {'CM_CommentsValidationOff'|@translate}
            </p>
          </div>
          <div class="cm_hide">
        {/if}

        <br><br>

          <div class="FieldTitle">
              {'CM_CommentsValidationOn'|@translate}
          </div>

        <br><br>

          <li>
            <label class="cluetip" title="{'CM_ValidCommTitle'|translate}|{'CM_ValidComm2Title_d'|translate}">
              {'CM_Validation_For_Group'|@translate}
            </label>

          <br><br>

            <input type="radio" value="false" {$CM_GROUPVALID2_FALSE} name="CM_GroupValid2">
              {'CM_Disable'|@translate}

          <br>

            <input type="radio" value="true" {$CM_GROUPVALID2_TRUE} name="CM_GroupValid2">
              {'CM_Enable'|@translate}

          <br><br>

            <ul>
              <li>
                <label>
                  {'CM_ValidComm_Group'|@translate}
                </label>

              <br><br>

                  {html_options name="CM_ValidComm_Group2" options=$ValidComm_Group2.group_options selected=$ValidComm_Group2.group_selected}
              </li>
            </ul>

          <br><br>

          </li>
      {if !$CM_VALIDATION}
        </div>
      {/if}
        </ul>
      </fieldset>
  {if !$CM_CFA}
    </div>
  {/if}

  {if $CM_CFA}
    <div class="cm_hide">
  {/if}
      <fieldset>
        <div class="FieldTitle">
          {'CM_CommentsForRegistered'|@translate}
        </div>
      <br>
        <ul>
          <li>
            <label class="cluetip" title="{'CM_GroupCommTitle'|translate}|{'CM_GroupCommTitle_d'|translate}">
              {'CM_Comments_For_Group'|@translate}
            </label>

            <br><br>

            <input type="radio" value="false" {$CM_GROUPCOMM_FALSE} name="CM_GroupComm">
              {'CM_Disable'|@translate}

            <br>

            <input type="radio" value="true" {$CM_GROUPCOMM_TRUE} name="CM_GroupComm">
              {'CM_Enable'|@translate}

            <br><br>

            <ul>
              <li>
                <label>
                  {'CM_AllowedComm_Group'|@translate}
                </label>

              <br><br>

                  {html_options name="CM_AllowComm_Group" options=$AllowComm_Group.group_options selected=$AllowComm_Group.group_selected}
              </li>
            </ul>

            <br><br>

          </li>

        {if !$CM_VALIDATION}
          <div class="FieldTitle">
            <p class="cluetip" title="{'CM_CommentsValidationOffTitle'|translate}|{'CM_CommentsValidationOffTitle_d'|translate}">
              {'CM_CommentsValidationOff'|@translate}
            </p>
          </div>
          <div class="cm_hide">
        {/if}

        <br><br>

          <div class="FieldTitle">
              {'CM_CommentsValidationOn'|@translate}
          </div>

        <br><br>

          <li>
            <label class="cluetip" title="{'CM_ValidCommTitle'|translate}|{'CM_ValidCommTitle_d'|translate}">
              {'CM_Validation_For_Group'|@translate}
            </label>

            <br><br>

            <input type="radio" value="false" {$CM_GROUPVALID1_FALSE} name="CM_GroupValid1">
              {'CM_Disable'|@translate}

            <br>

            <input type="radio" value="true" {$CM_GROUPVALID1_TRUE} name="CM_GroupValid1">
              {'CM_Enable'|@translate}

            <br><br>

            <ul>
              <li>
                <label>
                  {'CM_ValidComm_Group'|@translate}
                </label>

              <br><br>

                  {html_options name="CM_ValidComm_Group1" options=$ValidComm_Group1.group_options selected=$ValidComm_Group1.group_selected}
              </li>
            </ul>

            <br><br>

          </li>
      {if !$CM_VALIDATION}
        </div>
      {/if}
        </ul>
      </fieldset>
  {if $CM_CFA}
    </div>
  {/if}
  </fieldset>

  <p>
    <input class="submit" type="submit" value="{'CM_submit'|@translate}" name="submit" {$TAG_INPUT_ENABLED} >
  </p>
</form>


<fieldset>
  {'CM_Support_txt'|@translate}
</fieldset>

{html_head}
<script type="text/javascript">
jQuery(document).ready(function() {ldelim}
  jQuery('#theAdminPage #the_page').addClass('{$themeconf.name}');
	jQuery(".infos").fadeOut(800).fadeIn(1200).fadeOut(400).fadeIn(800).fadeOut(400);
	jQuery(".errors").fadeOut(200).fadeIn(200).fadeOut(300).fadeIn(300).fadeOut(400).fadeIn(400); 
});
</script>
{/html_head}