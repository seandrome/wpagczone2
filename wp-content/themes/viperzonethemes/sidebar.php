<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package web2feel
 * @since web2feel 1.0
 */
?>
		<div id="secondary" class="widget-area grid_3" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			
			<aside id="recent-products" class="widget">
			<h3 class="widget-title">Recent Products</h3>
			<?php
				$recent_posts = wp_get_recent_posts(array('numberposts' => '10'));
				foreach( $recent_posts as $recent ){
			?>
			<div class="recentlist">		
				<?php
					$thumb = get_post_meta($recent["ID"], 'thumb', true);
					$thumb = preg_replace("/._(.*)_.jpg/","._SS60_.jpg",$thumb);
					$rating = get_post_meta($recent["ID"],'rating',true);
					$listprice = get_post_meta($recent["ID"],'listprice',true);
					$price = get_post_meta($recent["ID"],'price',true);
				?>
				<div class="recthumb"><img src="<?php echo $thumb; ?>" width="60" height="60"/></div>
				<div class="rectitle"><h4><a href="<?php echo get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' . $recent["post_title"]; ?></a></h4></div>
				<div class="rat">
					<span class="zah_rating zah_rating_<?php echo zah_rate($rating); ?>"></span>
					<span class="sidebar_listprice"><?php echo (preg_replace('/[^0-9]/s', '', $listprice) > 0 ? $listprice : ""); ?></span>
					<span class="sidebar_price"><?php echo (preg_replace('/[^0-9]/s', '', $price) > 0 ? $price : ""); ?></span>
				</div>
			</div>
			<?php } ?>
			</aside>

			<aside id="kategori" class="widget widget_categories">
			<h3 class="widget-title">Product Categories</h3>
			<ul><?php wp_list_categories('orderby=name&title_li='); ?></ul>
			</aside>
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

				
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
