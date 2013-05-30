<?php
/**

Template Name: Homepage

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
	<div id="feature-section" class="cf">
		<div id="slide">
			<div id="slider">
				<div id="flexislider" class="flexslider">
					<ul class="slides">
					    <?php 	$count = of_get_option('w2f_slide_number');
								$slidecat =of_get_option('w2f_slide_categories');
								
								$query = new WP_Query( array( 'post_type' =>'post', 'orderby' => 'rand') );
					           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
					 	
						 		<li>
								<?php
									$image = get_post_meta($post->ID, 'images', true);
									if (!$image)
									{
										$image = get_post_meta($post->ID, 'thumb', true);
									}
									$image = preg_replace("/._(.*)_.jpg/","._AA358_.jpg",$image);
									//$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
									//$image = aq_resize( $thumb, 600, 358, false ); //resize & crop the image
								?>
								
								<?php if($image) : ?>
									<a href="<?php the_permalink(); ?>"><img class="slideimg" src="<?php echo $image ?>" width="358" height="358"/></a>
								<?php endif; ?>
				
								<div class="flex-caption">
								
									<h3><?php the_title(); ?> - <?php echo get_post_meta($post->ID,'price', true); ?></h3>   
									<?php /* <p><?php echo get_post_meta($post->ID,'features', true); ?></p> */ ?>
								</div>
						<?php endwhile; endif; ?>
								</li>
								    		
					</ul>
				</div>	
			</div>	
		</div>
		
		<div id="banner-block">
			<div class="head-banner">	<?php echo of_get_option('w2f_off_banner');	?>	</div>
			
			
		</div>
		
	</div>
			
	<div class="clear"></div>
	
	<div class="latest-head grid_12">
		<h3>New arrivals</h3>
	</div>
	
	<div id="primary" class="content-area container_12">
	<div id="article-area" class="cf ">
	<div class="article-list cf">
	<?php
		$prodnum=12;
		
		if ( get_query_var('paged') )
		    $paged = get_query_var('paged');
		elseif ( get_query_var('page') )
		    $paged = get_query_var('page');
		else
		    $paged = 1;
		$wp_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $prodnum, 'paged' => $paged ));
		?>
		<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		
			<div class="product-box grid_3">
				<div class="prod-thumb">
					<?php
						$thumb = get_post_meta($post->ID, 'thumb', true);
						$thumb = preg_replace("/._(.*)_.jpg/","._AA150_.jpg",$thumb);
					?>
					<?php if($thumb) : ?> <a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb ?>" width="150" height="150"/></a> <?php endif; ?>
				</div>
				
				<div class="prod-info">
					<div class="pricebar cf"> 
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php 
							$price = get_post_meta($post->ID,'price', true);
							$num = preg_replace('/[^0-9]/s', '', $price);
						?>
						<span class="pricetag"><?php echo ($price && $num > 0 ? $price : "&nbsp;"); ?> </span>
					</div>
					
					<p> <?php echo get_post_meta($post->ID,'desc', true); ?> </p>
					
					<div class="prod-footer cf">
						<span class="pleft"> <a href="<?php the_permalink(); ?>">View details</a> </span>
						<span class="pright"><a href="<?php echo get_post_meta($post->ID,'afflink', true); ?>">Buy Now</a> </span>
					</div>
				</div>
					
			</div>
			

				<?php endwhile; ?>

	</div>
	</div>
		
	<div class="grid_12">
		<?php kriesi_pagination(); ?>
	</div>
		
	</div><!-- #primary .content-area -->


<?php get_footer(); ?>