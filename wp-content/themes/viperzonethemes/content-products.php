<?php
/**
 * @package web2feel
 * @since web2feel 1.0
 */
?>
<div xmlns:v="http://rdf.data-vocabulary.org/#">
   <span typeof="v:Breadcrumb">
     <a href="<?php bloginfo('url'); ?>" rel="v:url" property="v:title">
      Home
    </a> &raquo;
   </span>
   <?php $category = get_the_category(); if($category[0]) { echo '<span typeof="v:Breadcrumb">
    <a href="'.get_category_link($category[0]->term_id ).'" rel="v:url" property="v:title">
      '.$category[0]->cat_name.'
    </a> &raquo;
   </span>'; } ?>
   <span typeof="v:Breadcrumb">
    <a href="<?php the_permalink(); ?>" rel="v:url" property="v:title">
      <?php the_title(); ?>
    </a>
   </span>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
	<div class="product-single-top cf">
		<div class="prod-image">
					<?php
						$thumb = get_post_meta($post->ID, 'thumb', true);
						$thumb = preg_replace("/._(.*)_.jpg/","._SS210_.jpg",$thumb);
						$largeimgs = get_post_meta($post->ID, 'images', false);
						if (count($largeimgs) > 1)
							$largeimg = $largeimgs[rand(0,count($largeimgs)-1)];
						else
							$largeimg = $largeimgs[0];
					?>
					<?php if($thumb) : ?> <?php if ($largeimg) { ?><a class="fancybox" href="<?php echo $largeimg?>"><?php } ?><img src="<?php echo $thumb ?>" width="210" height="210"/></a> <?php endif; ?>
		</div>
		
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-meta">
				 <?php echo get_the_term_list( $post->ID, 'category', 'Category: ', ', ', '' ); ?> 
			 </div><!-- .entry-meta -->
			 
			 <?php
				$rating = get_post_meta($post->ID,'rating', true);
				$reviews = get_post_meta($post->ID,'review', true);
				if ($rating) {
			 ?>
			<div class="rating_review"><span itemtype="http://data-vocabulary.org/Review-aggregate" itemscope="" itemprop="review"><span title="<?php echo $rating; ?> out of 5 stars" class="zah_rating zah_rating_<?php echo zah_rate($rating); ?>" itemprop="rating"><?php echo $rating; ?></span> </span><span itemprop="count"><?php echo $reviews; ?></span> Customer Reviews</div>			 
			<?php } ?>
			
			 <?php 
				$listprice = get_post_meta($post->ID,'listprice', true);
				$num = preg_replace('/[^0-9]/s', '', $listprice);
				if ($listprice && $num > 0)
				{
			?>			 
			 <p><span class="fieldprice">List Price:</span> <span class="listprice"><?php echo $listprice; ?></span></p>
			 <?php 
				}
				$price = get_post_meta($post->ID,'price', true); 
				$num = preg_replace('/[^0-9]/s', '', $price);
				if ($price && $num > 0)
				{
			 ?>
			 <p><span class="fieldprice">Amazon Price:</span> <span class="price"><?php echo get_post_meta($post->ID,'price', true); ?></span> (<?php the_date('Y-m-d'); ?> <?php the_time(); ?> - <abbr id="tip">Details</abbr>)</p> 
			 <div id="tooltip"></div>
			 <?php
				}
				$disc = get_post_meta($post->ID,'disc', true); 
				$num = preg_replace('/[^0-9]/s', '', $disc);
				if ($disc && $num > 0)
				{
			 ?>			 
			 <p><span class="fieldprice">Discount:</span> <span class="price"><?php echo get_post_meta($post->ID,'disc', true); ?></span></p> 
			 <?php } ?>
			 
			 <div class="the-price cf">
			 <?php
				$price = get_post_meta($post->ID,'listprice', true); 
				$num = preg_replace('/[^0-9]/s', '', $price);
				if ($price && $num > 0)
				{
			?>
				 <h3>Price: <?php echo get_post_meta($post->ID,'price', true); ?></h3> 
			<?php } ?>
				 <a href="<?php echo get_post_meta($post->ID,'afflink', true); ?>" class="buy-button">Purchase now </a>
			 </div>
		</header><!-- .entry-header -->



	</div>

	<div class="product-single-bottom">
	
	<div class="entry-content">
	<?php if (strlen(trim(strip_tags(get_the_content(''))))>0) { ?>
	<h2><?php the_title(); ?> Description</h2>
		<?php
			$imgs = get_post_meta($post->ID, 'images', false);
			if (count($imgs) > 1)
				$img = $imgs[rand(0,count($imgs)-1)];
			else
				$img = $imgs[0];
			
			$img = preg_replace("/._(.*)_.jpg/","._SS500_.jpg",$img);
			$afflink = get_post_meta($post->ID, 'afflink', true);
			if ($img)
			{
		?>			
		<div id="single-img">
			<p align="center"><a href="<?php echo $afflink; ?>" title="buy <?php the_title(); ?>"><img src="<?php echo $img; ?>" width="500" height="500"/></a></p>
			<p align="center"><a class="post-buy-button" href="<?php echo $afflink; ?>">Buy from Amazon </a></p>			
			<br class="clear"/>
		</div>		
		<?php
			}
		?>
		<?php the_content(); ?>
	<?php
		$features = get_post_meta($post->ID, 'productfeatures', false);
		if ($features)
		{
	?>
	<h2>Product Features</h2>
	<ul>
	<?php foreach ($features as $f) { ?>
		<li><?php echo $f; ?></li>
	<?php
			}
	?>
	</ul>
	<?php
		}
	?>
	
	<?php
		$reviews = get_post_meta($post->ID, 'customer_review', false);
		if ($reviews)
		{
	?>
	<h2>Customer Reviews</h2>
	<?php 
			foreach ($reviews as $r) { 
				//parse stars
				$DOM = new DOMDocument;
				$DOM->loadHTML($r);
				$items = $DOM->getElementsByTagName('div');
				
				$rev = array();
				
				foreach ($items as $item)
				{
					if ($item->getAttribute("class") == "rev_title")
						$rev['title'] = $item->nodeValue;
					if ($item->getAttribute("class") == "rev_author")
						$rev['author'] = $item->nodeValue;
					if ($item->getAttribute("class") == "rev_rating")
						$rev['rating'] = $item->nodeValue;
					if ($item->getAttribute("class") == "rev_content")
						$rev['content'] = DOMinnerHTML($item);												
				}
				
				if (count($rev)>0)
				{
	?>
					<div class="customer_review">
						<span title="<?php echo $rev['rating']; ?> out of 5 stars" class="zah_rating zah_rating_<?php echo zah_rate($rev['rating']); ?>" itemprop="rating"><?php echo $rev['rating']; ?></span>					
						<div class="rev_title"><?php echo $rev['title']; ?></div>
						<div class="rev_author">By <strong><?php echo $rev['author']; ?></strong></div>
						<div class="rev_content"><?php echo $rev['content']; ?></div>
					</div>
	<?php
				}
			}
		}
	?>

	<p align="right"><a class="post-buy-button" href="<?php echo $afflink; ?>">Buy from Amazon </a></p>				
	<?php } // if content exist ?>
	
	<?php
		$cat = get_the_category();
		if (isset($cat) && count($cat)>0)
			$cat_ID = $cat[0]->cat_ID;
	?>
	<?php
	global $post;
	$args = array( 'numberposts' => 3, 'offset'=> 1, 'category' => $cat_ID , 'orderby' => 'rand');
	$myposts = get_posts( $args );
	if ($myposts) { ?>
	<h2>Related Products</h2>
	<ul class="related_products">
	<?php foreach( $myposts as $post ) :	setup_postdata($post); ?>		
	<?php 
		$thumb = get_post_meta($post->ID, 'thumb', true);
		$thumb = preg_replace("/._(.*)_.jpg/","._SS150_.jpg",$thumb);
		
	?>
			<li>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="related-img"><a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb; ?>" width="150" height="150" border="0"/></a></div>
				<div class="related-prices">
					<div class="related-teks">
				<?php
					$listprice = get_post_meta($post->ID,'listprice', true); 
					$num = preg_replace('/[^0-9]/s', '', $listprice);
					if ($listprice && $num > 0)
					{						
				?>
					<p>List Price: <span class="sidebar_listprice"><?php echo $listprice; ?></span></p>
				<?php } ?>
				<?php
					$price = get_post_meta($post->ID,'price', true); 
					$num = preg_replace('/[^0-9]/s', '', $price);
					if ($price && $num > 0)
					{						
				?>				
					<p>Price: <span class="sidebar_price"><?php echo $price; ?></span></p>
				<?php } ?>
				<?php
					$disc = get_post_meta($post->ID,'disc', true); 
					$num = preg_replace('/[^0-9]/s', '', $disc);
					if ($disc && $num > 0)
					{						
				?>				
					<p>Discount: <span class="sidebar_price"><?php echo $disc; ?></span></p>
				<?php } ?>
				<?php
					$rating = get_post_meta($post->ID,'rating', true); 
					$num = preg_replace('/[^0-9]/s', '', $rating);
					if ($rating && $num > 0)
					{						
				?>									
					<p><span class="zah_rating_single zah_rating_<?php echo zah_rate($rating); ?>"></span></p>
				<?php } ?>					
					</div>					
				</div>
			</li>
	<?php endforeach; ?>
	</ul>		
	<?php } ?>
	
	
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'web2feel' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
