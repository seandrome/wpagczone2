<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package web2feel
 * @since web2feel 1.0
 */
?>

</div><!-- #main .site-main -->
</div>

<div id="bottom">
<div class="container_12 cf">
	<ul>
	<?php if ( !function_exists('dynamic_sidebar')
	        || !dynamic_sidebar("Footer") ) : ?>  
	<?php endif; ?>
	</ul>
</div>
</div>

<footer id="colophon" class="site-footer" role="contentinfo">
<div class="container_6">
<div class="site-info">
<?php static_footer_pages(); ?>
		<div class="fcred">
		Copyright &copy; <?php echo date('Y');?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> - <?php bloginfo('description'); ?>.<br />		
		</div>		
</div><!-- .site-info -->	
</footer><!-- #colophon .site-footer -->
	
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

<script type="text/javascript">
jQuery(document).ready(function($)
	{
	$('#tip').hover(function()
		{
		var tpo = $(this).parent().parent().width();
		$("#tooltip").html('<p>Product prices and availability are accurate as of the date/time indicated and are subject to change. Any price and availability information displayed on Amazon.com at the time of purchase will apply to the purchase of this product.</p>').css("width",
			tpo - 20).fadeIn("fast");
		}, function()
		{
		$("#tooltip").html('').fadeOut('fast');
		});
	});	
</script>
<script type="text/javascript">
  var vglnk = { api_url: '//api.viglink.com/api',
                key: 'c5d8f82b94ccf34b3c04d4ff2e0d11cb' };

  (function(d, t) {
    var s = d.createElement(t); s.type = 'text/javascript'; s.async = true;
    s.src = ('https:' == document.location.protocol ? vglnk.api_url :
             '//cdn.viglink.com/api') + '/vglnk.js';
    var r = d.getElementsByTagName(t)[0]; r.parentNode.insertBefore(s, r);
  }(document, 'script'));
</script>
</body>
</html>