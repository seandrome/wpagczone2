<?php 
/*
Plugin Name: Drop-down-custom-taxonomy
Plugin URI: http://wordpress.org/extend/plugins/taxonomy-terms-list/
Description: Adds drop-down custom taxonomy box to users desired location
Version: 0.1
Author: Niraj Chauhan
Author URI: http://nirajchauhan.co.cc/, http://mbas.in
License: GPLv2

Copyright 2010  Niraj-M-Chauhan http://nirajchauhan.co.cc/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Check the demo on http://mbas.in

Compatible with WordPress Versions:
	- 3.0
	- 3.0.1
	- 3.0.2
	- 3.0.3

*/
function the_dropdown_taxonomy($taxonomy) {

  $id = "{$taxonomy}-dropdown";
  $js =<<<SCRIPT
<script type="text/javascript">
 jQuery(document).ready(function($){
  $("select#{$id}").change(function(){
    window.location.href = $(this).val();
  });
 });
</script>
SCRIPT;
  echo $js;
  $terms = get_terms($taxonomy);
  echo "<select name=\"{$id}\" id=\"{$id}\">";
echo '<option value="#"> Department </option>';
  foreach($terms as $term) {
    echo '<option value="';
    echo get_term_link(intval($term->term_id),$taxonomy);
    echo '">' . "{$term->name}</option>";
  }
  echo "</select>";
  }

add_action('init','jquery_init');
function jquery_init() {
  wp_enqueue_script('jquery');
}
?>