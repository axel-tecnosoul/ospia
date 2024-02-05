<?php
    $action = array( 'active'=> 'Deactivate', 'deactive' => 'Activate');
    $activate_btn_text = (empty($effected)) ? "Activate" : $action[$effected];
?>
<div class="settings-field dg-activation">
    <input id="<?php echo $id;?>" class="apikey" type='text' 
    name='<?php echo $name;?>' 
    value='<?php echo $value; ?>' /> 
    <button id="action-button" class="act-btn" data-license-key="<?php echo $id;?>" data-effected-key="<?php echo $effected_key;?>">
        <span class="text"><?php echo $activate_btn_text;?></span> 
        <!-- <span class="loader">&#8635;</span> -->
        <span class="loader"><img src="<?php echo DGSETTINGSURL;?>/assets/img/spin.gif" width="20" height="20"/></span>
    </button>
    <p class="error"></p>
</div>
