<?php
/**
   Template name: Shop
   
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package web2feel
 * @since web2feel 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area cf">
			<div id="content" class="site-content" role="main">
<div class="article-list cf">
		<?php
		if ( get_query_var('paged') )
		    $paged = get_query_var('paged');
		elseif ( get_query_var('page') )
		    $paged = get_query_var('page');
		else
		    $paged = 1;
		$wp_query = new WP_Query(array('post_type' => 'products', 'posts_per_page' => '4', 'paged' => $paged ));
		?>
		<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		
			<div class="product-box grid_3">
				<div class="prod-thumb">
					<?php
						$thumb = get_post_thumbnail_id();
						$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
						$image = aq_resize( $img_url, 180, 150, false ); //resize & crop the image
					?>
					<?php if($image) : ?> <a href="<?php the_permalink(); ?>"><img src="<?php echo $image ?>"/></a> <?php endif; ?>
				</div>
				
				<div class="prod-info">
					<div class="pricebar cf"> 
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<span class="pricetag"><?php echo get_post_meta($post->ID,'_product_info_product_price', true); ?> </span>
					</div>
					
					<p> <?php echo get_post_meta($post->ID,'_product_info_product_description', true); ?> </p>
					
					<div class="prod-footer cf">
						<span class="pleft"> <a href="<?php the_permalink(); ?>">View details</a> </span>
						<span class="pright"><a href="<?php echo get_post_meta($post->ID,'_product_info_product_link', true); ?>">Buy Now</a> </span>
					</div>
				</div>
					
			</div>
			

				<?php endwhile; ?>
</div>
				<?php //web2feel_content_nav( 'nav-below' ); ?>
				<div class="grid_12">
				<?php kriesi_pagination("$wp_query->max_num_pages"); ?>
				
				</div>
				
			

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>