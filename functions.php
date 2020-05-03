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
require get_template_directory() . '/inc/theme-functions.php';

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
 * Register widget area and custom recent comments widget.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
require get_template_directory() . '/widgets/class-zan-widget-recent-comments.php';

function zan_widgets_init()
{
	unregister_widget('WP_Widget_Recent_Comments');
	register_widget('Zan_Widget_Recent_Comments');

	register_sidebar(array(
		'id'            => 'sidebar-1',
		'name'          => __('Blog Sidebar', 'default'),
		'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'default'),
		'before_widget' => '<section id="%1$s" class="panel panel-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="panel-heading"><h2 class="widgettitle">',
		'after_title'   => '</h2><i class="fa fa-times-circle panel-btn-remove"></i><i class="fa fa-chevron-circle-up panel-btn-toggle"></i></div>',
	));

	register_sidebar(array(
		'id'            => 'sidebar-2',
		'name'          => __('Home Banner', 'default'),
		'description'   => __('Add widgets here to appear in your home banner.', 'default'),
		'before_widget' => '<section id="%1$s" class="panel panel-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="panel-heading"><h2 class="widgettitle">',
		'after_title'   => '</h2><i class="fa fa-times-circle panel-btn-remove"></i><i class="fa fa-chevron-circle-up panel-btn-toggle"></i></div>',
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

	wp_enqueue_style('fontawesome', 'http://comet.uki.site/fontawesome/css/all.css', array(), null);

	// Theme stylesheet.
	wp_enqueue_style('zan-core-style', get_theme_file_uri('/assets/css/core.css'), array(), '20200430');
	wp_enqueue_style('zan-style', get_stylesheet_uri(), array(), '20200430');

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.0.min.js', array(), null);

	//wp_enqueue_script('popper.js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), null);

	//wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery', 'popper.js'), null);

	wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', array('jquery'), null);

	wp_enqueue_script('zan-script', get_theme_file_uri('/assets/js/zanblog.js'), array('jquery'), '20200430');

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'zan_scripts');


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

	if ('page' === get_post_type() && is_page_template('page-templates/full-width.php')) {
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
	if ('post-thumbnail' === $size) {
		if (is_active_sidebar('sidebar-1')) {
			$attr['sizes'] = '(max-width: 768px) 93vw, (max-width: 992px) 682px, (max-width: 1200px) 579px, 712px';
		} else {
			$attr['sizes'] = '93vw';
		}
	}

	return $attr;
}
//add_filter('wp_get_attachment_image_attributes', 'zan_post_thumbnail_sizes_attr', 10, 3);

function zan_excerpt_length($length)
{
	if (is_singular()) {
		return 80;
	} else {
		return 250;
	}
}
add_filter('excerpt_length', 'zan_excerpt_length');

function zan_breadcrumb($is_block = true)
{
	if (function_exists('bcn_display')) :
?>
		<div class="breadcrumb<?php if ($is_block) echo ' panel panel-default'; ?>" itemscope itemtype="https://schema.org/BreadcrumbList">
			<i class="fa fa-home"></i> <?php bcn_display(); ?>
		</div>
<?php
	endif;
}

function zan_color_cloud($text)
{
	return preg_replace_callback('/<a (.+?)>/i', 'zan_color_cloud_callback', $text);
}

function zan_color_cloud_callback($matches)
{
	$text = $matches[1];
	$h = rand(0, 360);
	$s = rand(80, 100);
	$l = rand(30, 40);
	$pattern = '/style=(\'|\")(.*)(\'|\")/i';
	$text = preg_replace($pattern, 'style="color: hsl(' . $h . ',' . $s . '%,' . $l . '%);$2;"', $text);

	return "<a $text>";
}
add_filter('wp_tag_cloud', 'zan_color_cloud', 1);

/**
 * Custom Tag cloud.
 */
function zan_tag_cloud_args($args)
{
	$args['smallest'] = '8';
	$args['largest'] = '22';
	return $args;
}
add_filter('widget_tag_cloud_args', 'zan_tag_cloud_args');


/**
 * Custom WP_PostViews Widget and template.
 */
function zan_option_views_options($value)
{
	$value['template'] = '%VIEW_COUNT%';
	$value['most_viewed_template'] = '<li><a href="%POST_URL%" title="%POST_TITLE%">%POST_TITLE%</a><span class="badge"><i class="fa fa-eye"></i> %VIEW_COUNT%</span></li>';
	return $value;
}
add_filter('option_views_options', 'zan_option_views_options');

/**
 * Custom password protected post's title prefix.
 */
function zan_protected_title_format()
{
	return '<i class="fa fa-lock"></i> %s';
}
add_filter('protected_title_format', 'zan_protected_title_format');

/**
 * Add Font Awesome support in widget title.
 * A title like 'i$fa fa-sync-alt$ Title' will be replaced with '<i class="fa fa-sync-alt"></i>  Title'
 */
function zan_widget_title($title)
{
	return preg_replace_callback('/i\$(.*?)\$/', 'zan_widget_title_callback', $title);
}

function zan_widget_title_callback($matches)
{
	return '<i class="' . $matches[1] . '"></i>';
}
add_filter('widget_title', 'zan_widget_title');

/**
 * Custom private post's title prefix.
 */
function zan_private_title_format()
{
	return '<i class="fa fa-eye-slash"></i> %s';
}
add_filter('private_title_format', 'zan_private_title_format');

if (version_compare($GLOBALS['wp_version'], '4.9.0', '>=')) {
	/**
	 * Add a method to use WP_Widget_Recent_Posts to show random posts. 
	 */
	function zan_widget_posts_args($args, $instance)
	{
		if (strpos($instance['title'], 'i$random-posts$') !== false) {
			$args['orderby'] = 'rand';
		}
		$args['has_password'] = false;
		return $args;
	}
	add_filter('widget_posts_args', 'zan_widget_posts_args', 10, 2);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
