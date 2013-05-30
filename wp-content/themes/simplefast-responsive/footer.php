<div style="clear: both"></div>
</div>
<footer id="footer">
<?php $pages = wp_list_pages('depth=1&title_li=&echo=0');
$pages2 = preg_split('/(<li[^>]*>)/' ,$pages);foreach($pages2 as $var){
echo str_replace('</li>', '', $var);}?><br/>
Copyright &#169; <?php echo date("Y") ?>  <a href="<?php echo home_url() ; ?>"><?php bloginfo('name'); ?></a>, All trademarks are the property of the respective trademark owners. <br/>
<?php wp_footer(); ?>
</footer>
</div>
</body>
</html>