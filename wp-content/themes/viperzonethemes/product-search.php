<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package web2feel
 * @since web2feel 1.0
 */

get_header(); ?>

		<section id="primary" class="content-area grid_9">
			<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'web2feel' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php //web2feel_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<div id="primary" class="content-area container_12">
				<div id="article-area" class="cf ">
				<div class="article-list cf">				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>
<?php
$keyword = get_search_query();
$template = 'kodesppimage.html'; // semisal kita bikin template sendiri untuk wikipedia
$hack = 'site:amazon.com'; // hack ini akan menampilkan konten HANYA dari en.wikipedia.org
echo spp($keyword, $template, $hack);
?>
				<?php endwhile; ?>

				</div>
				</div>
				
				<?php kriesi_pagination(); ?>
				
				</div>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'search' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

<?php get_footer(); ?>