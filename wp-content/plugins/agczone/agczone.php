<?php 
/*
	Plugin Name: AGCZone
	Plugin URI: http://www.bloggingline.com/
	Description: Simple Display Amazon Content on Your Blog
	Author: Sarkem ADS-ID
	Version: 1.0
	Author URI: http://www.bloggingline.com/
*/
/*  Copyright 2013  Sarkem ADS-ID  (email : im@sarkem.me) Truly Dedicated for my son's Devan N.P

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Sarkem Media, Inc.
*/
?>
<?php
$license = 'hBQCL';
add_action('admin_menu', 'AGCZone_Menu');
function AGCZone_Menu()
{
	add_menu_page('AGCZone Plugin Settings', 'AGCZone Settings', 'administrator', __FILE__, 'AGCZone_Settings',plugins_url('/images/amazon-16.png', __FILE__));
	add_action( 'admin_init', 'AGCZone_Register' );
}
function AGCZone_Register() {
	register_setting( 'az-settings-group', 'affid' );
	register_setting( 'az-settings-group', 'apikey' );
	register_setting( 'az-settings-group', 'secret_key' );
	register_setting( 'az-settings-group', 'region' );
	register_setting( 'az-settings-group', 'department' );
}

function AGCZone_Settings()
{
	echo '<div class="wrap">';
	echo '<h2>AGCZone Plugins Settings</h2>';
	
	echo '<form method="post" action="options.php">';
	echo settings_fields( 'az-settings-group' );
	echo get_settings( 'az-settings-group' );
	echo '<table class="form-table">';
	echo '<tr valign="top">';
	echo '<th scope="row">Your Amazon Affiliate ID</th>';
	echo '<td><input type="text" name="affid" value="'.get_option('affid').'" /></td>';
	echo '</tr>';
			 
	echo '<tr valign="top">';
	echo '<th scope="row">Your Amazon API Key</th>';
	echo '<td><input type="text" name="apikey" value="'.get_option('apikey').'" /></td>';
	echo '</tr>';
			
	echo '<tr valign="top">';
	echo '<th scope="row">Your Amazon Secret Key</th>';
	echo '<td><input type="text" name="secret_key" value="'.get_option('secret_key').'" /></td>';
	echo '</tr>';

	echo '<tr valign="top">';
	echo '<th scope="row">Amazon Country</th>';
	echo '<td><input type="text" name="region" value="'.get_option('region').'" /></td>';
	echo '</tr>';
	
	echo '<tr valign="top">';
	echo '<th scope="row">Sets Category</th>';
	echo '<td><input type="text" name="department" value="'.get_option('department').'" /></td>';
	echo '</tr>';
	
	echo '</table>';
	echo submit_button();
	
	echo '</form>';
	echo '</div>';
}
function AGCZone_XML($tag, $api, $secretkey, $region, $department, $query)
{
	$time = time() + 10000;
	$method = 'GET';
	$host = 'webservices.amazon.'.$region;
	$uri = '/onca/xml';
	$slug["Service"] = "AWSECommerceService";
	$slug["Operation"] = "ItemSearch";
	$slug["SubscriptionId"] = $api;
	$slug["AssociateTag"] = $tag;
	$slug["SearchIndex"] = $department;
	$slug["Condition"] = 'All';
	$slug["Keywords"] = $query;
	$slug["ItemPage"] = 1;
	$slug["TruncateReviewsAt"] = '500'; // silahkan ganti sesuai keinginan
	$slug["ResponseGroup"] = 'Large'; // Silahkan check di Amazon API Untuk mengganti scheme responnya.
	$slug["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z",$time);
	$slug["Version"] = "2011-08-01";
	ksort($slug);
	$query_slug = array();
	foreach ($slug as $slugs=>$value)
	{
		$slugs = str_replace("%7E", "~", rawurlencode($slugs));
		$value = str_replace("%7E", "~", rawurlencode($value));
		$query_slug[] = $slugs."=".$value;
	}
	$query_slug = implode("&", $query_slug);
	$signinurl = $method."\n".$host."\n".$uri."\n".$query_slug;
	$signature = base64_encode(hash_hmac("sha256", $signinurl, $secretkey, True));
	$signature = str_replace("%7E", "~", rawurlencode($signature));
	$request = "http://".$host.$uri."?".$query_slug."&Signature=".$signature;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $request);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
function AGCZoneContent()
{
	$tag = get_option('affid');
	$api = get_option('apikey');
	$sec = get_option('secret_key');
	$reg = get_option('region');
	$dep = get_option('department');
	if(is_single())
	{
		$query = get_the_title($post->ID);
	}
	elseif(is_search())
	{
		$query = get_search_query();
	}
	$ama = AGCZone_XML($tag, $api, $sec, $reg, $dep, $query);
	if(@simplexml_load_string($ama))
	{
		$xmlzone = new SimpleXmlElement($ama, LIBXML_NOCDATA);
		$fetsaya = $xml->ItemAttributes->Feature;
		$xml = $xmlzone->Items->Item;
		$result = '<h2 class="agczone-title">'.$xml[0]->ItemAttributes->Title.'</h2>' . "\n";
		
		$result .= '<div class="agczone-thumbnail"><a href="http://www.amazon.'.$reg.'/gp/product/'.$xml[0]->ASIN.'/'.$tag.'" rel="nofollow" target="_blank"><center><img class="agczone-left" src="'.$xml[0]->LargeImage->URL.'" data-src="'.$xml[0]->LargeImage->URL.'" width="'.$xml[0]->LargeImage->Width.'" height="'.$xml[0]->LargeImage->Height.'" alt="'.$xml[0]->ItemAttributes->Title.'" /></br></br><font size="5" color="black">Price <s>'.$xml[0]->ItemAttributes->ListPrice->FormattedPrice.' </s></br> or </br> <a href="http://www.amazon.'.$reg.'/gp/product/'.$xml[0]->ASIN.'/'.$tag.'" rel="nofollow" target="_blank"><blink><font color="red">... Check Discount at Here ...</font></blink></a></font></center></a></div>' . "\n </br>";
		$result .= '<div class="agczone-details">' . "\n";
		$result .= '<table class="agczone-table">';
		$result .= '<tbody>';
		$result .= '<tr style="background:#eee;width:100%;">' . "\n";
		$result .= '<td class="agczone-td">Check Price</td>' . "\n";
		$result .= '<td>:</td>' . "\n";
		$result .= '<td class="agczone-td"><center><b><font color="red"><s>'.$xml[0]->ItemAttributes->ListPrice->FormattedPrice.'</s> - <a href="http://www.amazon.'.$reg.'/gp/product/'.$xml[0]->ASIN.'/'.$tag.'" rel="nofollow" target="_blank"><blink>[ Check Discount ]</blink></a></font></b></center></td>' . "\n";
		$result .= '</tr>' . "\n";
		$result .= '<tr style="background:#fff;">' . "\n";
		$result .= '<td class="agczone-td">Brand</td>' . "\n";
		$result .= '<td>:</td>' . "\n";
		$result .= '<td class="agczone-td">'.$xml[0]->ItemAttributes->Brand.'</td>' . "\n";
		$result .= '</tr>' . "\n";
		$result .= '<tr style="background:#eee;">' . "\n";
		$result .= '<td class="agczone-td">Binding</td>' . "\n";
		$result .= '<td>:</td>' . "\n";
		$result .= '<td class="details">'.$xml[0]->ItemAttributes->Binding.'</td>' . "\n";
		$result .= '</tr>' . "\n";
		$result .= '<tr style="background:#fff;">' . "\n";
		$result .= '<td class="agczone-td">Color</td>' . "\n";
		$result .= '<td>:</td>' . "\n";
		$result .= '<td class="agczone-td">'.$xml[0]->ItemAttributes->Color.'</td>' . "\n";
		$result .= '</tr>' . "\n";
		$result .= '<tr style="background:#eee;">' . "\n";
		$result .= '<td class="agczone-td">Model</td>' . "\n";
		$result .= '<td>:</td>' . "\n";
		$result .= '<td class="agczone-td">'.$xml[0]->ItemAttributes->Model.'</td>' . "\n";
		$result .= '</tr>' . "\n";
		$result .= '<tr style="background:#fff;">' . "\n";
		$result .= '<td class="agczone-td">SKU</td>' . "\n";
		$result .= '<td>:</td>' . "\n";
		$result .= '<td class="agczone-td">'.$xml[0]->ItemAttributes->SKU.'</td>' . "\n";
		$result .= '</tr>' . "\n";
		$result .= '</tbody>' . "\n";
		$result .= '</table>' . "\n";
		$result .= '</div><br/>' . "\n";
		$result .= '<div style="clear:both"></div><br/>' . "\n";
		$result .= '<p style="text-align:center">Go To Product</br><a href="http://www.amazon.'.$reg.'/gp/product/'.$xml[0]->ASIN.'/'.$tag.'" rel="nofollow" target="_blank"><img src="http://kloget-kloget.zz.mu/document/amazon.png" /></a></p>' . "\n";
               
                $result .= '<h3>Description '.$xml[0]->ItemAttributes->Title.'</h3><br/>' . "\n"; 
		$description = $xml[0]->EditorialReviews->EditorialReview->Content[0];
		if (strlen($description) > 1000)
		{
			$limitsdesc = substr($description, 0, 1000);
		}
		else
		{
			$limitsdesc = $description;
		}

		$result .= $limitsdesc;
		return $result;
	}
}
function AGCZoneSheet()
{
	$sheeturl = plugins_url('/agczoneonesheet2.css', __FILE__);
	$moourl = plugins_url('/mootools2.js', __FILE__);
	$lazyurl = plugins_url('/Lazy2.js', __FILE__);
	echo '<link rel="stylesheet" media="all" href="'.$sheeturl.'" />' . "\n";
	echo '<script type="text/javascript" src="'.$moourl.'"></script>' . "\n";
	echo '<script type="text/javascript" src="'.$lazyurl.'"></script>' . "\n";
}
add_filter('wp_head', 'AGCZoneSheet');
function AGCZoneLicense()
{
	$license = 'hBQCL';
	echo '<div class="agczonelicense"><a href="http://goo.gl/'.$license.'" target="_blank">AGCZone WP Plugins</a></div>' . "\n";
}
add_filter('wp_footer', 'AGCZoneLicense');
?>