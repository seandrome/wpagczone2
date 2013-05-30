<?php
/*
Plugin Name: Nofollow for external link
Plugin URI: http://www.cybernetikz.com
Description: Just simple, if you use this plugins, `rel=&quot;nofollow&quot;` and `target=&quot;_blank&quot;` will be added automatically, for all the external links of your website posts or pages.
Version: 1.0
Author: CyberNetikz
Author URI: http://www.cybernetikz.com
License: GPL2
*/

add_filter( 'the_content', 'cn_nf_url_parse');

function cn_nf_url_parse( $content ) {

	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
	if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
		if( !empty($matches) ) {
			
			$srcUrl = get_option('siteurl');
			$noFollow = ' rel="nofollow" ';
			for ($i=0; $i < count($matches); $i++)
			{
			
				$tag = $matches[$i][0];
				$tag2 = $matches[$i][0];
				$url = $matches[$i][0];

				$pattern = '/target\s*=\s*"\s*_blank\s*"/';
				preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
				if( count($match) < 1 )
					$noFollow = ' rel="nofollow" target="_blank" ';
			
				$pos = strpos($url,$srcUrl);
				if ($pos === false) {
					$tag = rtrim ($tag,'>');
					$tag .= $noFollow.'>';
					$content = str_replace($tag2,$tag,$content);
				}
			}
		}
	}
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;

}