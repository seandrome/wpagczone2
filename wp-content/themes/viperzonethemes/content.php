<?php
/**
 * @package web2feel
 * @since web2feel 1.0
 */
?>

<div class="product-box grid_3">
	<div class="prod-thumb">
		<?php
			$thumb = get_post_meta($post->ID, 'thumb', true);
		?>
		<?php if($thumb) : ?> <a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb ?>"/></a> <?php endif; ?>
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