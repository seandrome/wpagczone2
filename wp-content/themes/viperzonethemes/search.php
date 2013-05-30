<?php
$search_refer = $_GET["post_type"];
if ($search_refer == 'products') { load_template(TEMPLATEPATH . '/product-search.php'); }
else{ load_template(TEMPLATEPATH . '/default-search.php'); };
?>