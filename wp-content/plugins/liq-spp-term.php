<?php
/*
Plugin Name: SPP inject Term
Description: Inject Term ke SPP buatan Mastah Masbuchin yg keren banget. SPP HARUS DI INSTALL DULU. 9/5/2012
Plugin URI: http://ninjaplugins.com/products/stupidpie
Author: CoLiq
Author URI: http://coliq.us
Version: 0.0.2
*/

add_action('admin_menu', 'liq_spp_inject',11);

function liq_spp_inject(){
add_menu_page('SPP Settings',__('SPP setting','spp'), 'administrator', __FILE__,'liq_spp_term_callback','');
}


function liq_spp_insertdb(){
global $wpdb;

	if(isset($_POST['liq_spp_term'])){
		$aterm = array();
		
		if(isset($_POST['spp_linebreak']))
			$aterm = explode("\n", $_POST['liq_spp_term']);
		else
			$aterm = explode(',', $_POST['liq_spp_term']);

		if(sizeof($aterm) > 0){
			$tot = 0;
			foreach($aterm as $term){
				if( !empty($term) && spp_filter_before_save($term) ){
					if($wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO ".$wpdb->prefix."spp (`term` ) VALUES ( %s )", trim($term) )) ) $tot++;
				}
			}
		}


    echo '<div id="message" class="updated">
	<p style="text-align:center;"><strong>'.$tot .'</strong> of <strong>'. sizeof($aterm).'</strong> total terms inserted.</p>
    </div>';
				
	}
}

function liq_spp_term_callback(){
	if(isset($_POST['liq_spp_term'])){liq_spp_insertdb();}
?>

	<div class="wrap">
	<div id="icon-options-general" class="icon32">
	<br></div>
	<h2>Add Term to SPP</h2>
	<table class="widefat" id="icl_languages_selection_table">
				<thead>
					<tr>
						<th>Add Term to SPP</th>
					</tr>
				</thead>
	<tbody>
	<tr><td>	
	<form method="post" action="">


		<table class="form-table">
			<tbody>
			<tr valign="top">
			<td><input type="checkbox" id="" name="spp_linebreak" /> I m using line break
			</td>
			</tr>
			<tr valign="top">
			<td>
			<textarea id="" rows="10" cols="120" name="liq_spp_term"></textarea></td>
			</tr>
			<tr><td>
			Note: make sure each term separated by comma ",". example:<br>
			<span style="font-size:12px;font-family:arial;color:blue;">
			spp oke banget gitu loh, masbuchin gianteng, gerakan anti galau indonesia
			</span>
			</td>
			</tr>
			</tbody>
			 
		</table>
		
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Insert') ?>" />
		</p>

	</form>
	</td></tr>
	</tbody>
	</table>

	</div>

<?php
}
?>