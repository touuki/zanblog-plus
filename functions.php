<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */


// 加载主题函数文件
require get_parent_theme_file_path('/inc/theme-functions.php');

// 加载小工具文件
require get_parent_theme_file_path('/widgets.php');


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function zan_setup()
{
	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');
	//set_post_thumbnail_size( 1200, 9999 );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://wordpress.org/support/article/post-formats/
	 */
	//add_theme_support('post-formats',array('aside','image','video','quote','link','gallery','audio',));

	// Add theme support for Custom Logo.
	add_theme_support(
		'custom-logo',
		array(
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
	  */
	//add_editor_style( array( 'assets/css/editor-style.css', zan_fonts_url() ) );

	// Load regular editor styles into the new block-based editor.
	add_theme_support('editor-styles');

	// Load default block styles.
	add_theme_support('wp-block-styles');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');

	// Add support for custom background.
	add_theme_support('custom-background');
}
add_action('after_setup_theme', 'zan_setup');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function zan_widgets_init()
{

	register_sidebar(array(
		'id'            => 'sidebar-1',
		'name'          => __('Blog Sidebar', 'default'),
		'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'default'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>'
	));

	register_sidebar(array(
		'id'            => 'sidebar-2',
		'name'          => __('Home Banner', 'default'),
		'description'   => __('Add widgets here to appear in your home banner.', 'default'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>'
	));
}
add_action('widgets_init', 'zan_widgets_init');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since ZanBlog Plus 1.0
 */
function zan_javascript_detection()
{
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'zan_javascript_detection', 0);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function zan_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'zan_pingback_header');


/**
 * Enqueues scripts and styles.
 */
function zan_scripts()
{
	//wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), null);

	wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css', array(), null);
	//wp_enqueue_style('bootstrap', get_theme_file_uri('/assets/css/bootstrap.css'), array(), null);

	wp_enqueue_style('fontawesome', 'http://comet.uki.site/fontawesome/css/all.css', array(), null);

	// Theme stylesheet.
	wp_enqueue_style('zan-core-style', get_theme_file_uri('/assets/css/core.css'), array(), '20200430');
	wp_enqueue_style('zan-style', get_stylesheet_uri(), array(), '20200430');

	wp_deregister_script( 'jquery' );
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.0.min.js', array(), null);

	//wp_enqueue_script('popper.js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), null);

	//wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery', 'popper.js'), null);

	wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', array('jquery'), null);
	//wp_enqueue_script('bootstrap', get_theme_file_uri('/assets/js/bootstrap.js'), array('jquery'), null);

	wp_enqueue_script('zan-script', get_theme_file_uri('/assets/js/zanblog.js'), array('jquery'), '20200430');

	wp_enqueue_script('modernizr', get_theme_file_uri('/assets/js/modernizr.js'), array(), null);
	wp_script_add_data('modernizr', 'conditional', 'lt IE 9');
	wp_enqueue_script('respond', get_theme_file_uri('/assets/js/respond.min.js'), array(), null);
	wp_script_add_data('respond', 'conditional', 'lt IE 9');
	// Load the html5 shiv.
	wp_enqueue_script('html5', get_theme_file_uri('/assets/js/html5shiv.js'), array(), null);
	wp_script_add_data('html5', 'conditional', 'lt IE 9');
}
add_action( 'wp_enqueue_scripts', 'zan_scripts' );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since ZanBlog Plus 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function zan_content_image_sizes_attr($sizes, $size)
{
	$width = $size[0];

	if ('page' === get_post_type() && is_page_template('page-templates/page-full-width.php')) {
		$sizes = '93vw';
	} else {
		$sizes = '(max-width: 768px) 93vw, (max-width: 992px) 682px, (max-width: 1200px) 579px, 712px';
	}

	return $sizes;
}
add_filter('wp_calculate_image_sizes', 'zan_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since ZanBlog Plus 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function zan_post_thumbnail_sizes_attr($attr, $attachment, $size)
{
	if ('page' === get_post_type() && is_page_template('page-templates/page-full-width.php')) {
		$attr['sizes'] = '93vw';
	} else {
		$attr['sizes'] = '(max-width: 768px) 93vw, (max-width: 992px) 682px, (max-width: 1200px) 579px, 712px';
	}

	return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'zan_post_thumbnail_sizes_attr', 10, 3);


function zan_breadcrumb($is_block = true)
{
	if (function_exists('bcn_display')) : ?>
		<div class="breadcrumb <?php if ($is_block) echo 'panel panel-default'; ?>">
			<i class="fa fa-home"></i>
			<?php bcn_display(); ?>
		</div>
<?php endif;
}


/**
 * Customizer additions.
 */
require get_parent_theme_file_path('/inc/customizer.php');
