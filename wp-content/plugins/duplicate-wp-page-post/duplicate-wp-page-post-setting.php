<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap dpp_page_settings">
<h1><?php _e('Plugin Settings', 'dpp_wpp_page')?></h1>
<?php $dpp_options = array();
$opt = get_option('dpp_wpp_page_options');
$instruct = isset($_GET['instruct']) ? $_GET['instruct'] : '';
if(isset($_POST['submit_dpp_wpp_page']) && wp_verify_nonce( $_POST['dpp_nonce_field'], 'dpp_page_action' )):
	_e("<strong>changes saving..</strong>", 'dpp_wpp_page');
	$dpp_nosave = array('submit_dpp_wpp_page');
	foreach($dpp_nosave as $noneed):
	  unset($_POST[$noneed]);
	endforeach;
		foreach($_POST as $key => $val):
		$dpp_options[$key] = $val;
		endforeach;
		 $dpp_settings_save = update_option('dpp_wpp_page_options', $dpp_options );
		if($dpp_settings_save){ dpp_wpp_page::dp_redirect('options-general.php?page=dpp_page_settings&instruct=1'); }
		else{ dpp_wpp_page::dp_redirect('options-general.php?page=dpp_page_settings&instruct=2'); }endif;
if(!empty($instruct) && $instruct == 1):
  _e( '<div class="updated settings-error dpp_pluginnotice is-dismissible" id="setting-error-settings_updated"> 
<p><strong>Changes saved.</strong></p><button class="notice-ignore" type="button"><span class="screen-reader-text">Ignore this notice.</span></button></div>', 'dpp_wpp_page');	
elseif(!empty($instruct) && $instruct == 2):
  _e( '<div class="error settings-error dpp_pluginnotice is-dismissible" id="setting-error-settings_updated"> 
<p><strong>Changes not saved.</strong></p><button class="notice-ignore" type="button"><span class="screen-reader-text">Ignore this notice.</span></button></div>', 'dpp_wpp_page');
endif;
$dpp_post_status = array('draft');
?> 
<div id="dpp-stuff">
<div id="dpp-post-body" class="metabox-holder columns-2">
<div id="dpp-post-body-content" style="position: relative;">
<form style="padding: 10px; border: 1px solid #333;" action="" method="post" name="dpp_wpp_page_form">
<?php  wp_nonce_field( 'dpp_page_action', 'dpp_nonce_field' ); ?>
<table class="form-table">
<tbody>
<tr><th scope="row"><label for="dpp_post_suffix"><?php _e('Duplicate Post Suffix', 'dpp_wpp_page')?></label></th>
<h3 style="color: red;"><?php _e('Add a suffix for duplicate or clone post as Copy, Clone etc. It will show after title.', 'dpp_wpp_page')?></h3>
<td><input type="text" class="regular-text" value="<?php echo !empty($opt['dpp_post_suffix']) ? $opt['dpp_post_suffix'] : ''?>" id="dpp_post_suffix" name="dpp_post_suffix"></td>
</tr>
</tbody>
</table>
<p class="submit"><input type="submit" value="Save Settings" class="button button-primary" id="submit" name="submit_dpp_wpp_page"></p>
</form>
</div>
</div>
</div>
</div>
</div>
</div>