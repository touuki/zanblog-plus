<?php

/**
 * ZanBlog Plus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

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

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'top'    => __('Top Menu', 'zanblog-plus'),
			'social' => __('Social Links Menu', 'zanblog-plus'),
		)
	);

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
			'width'      => 200,
			'height'     => 50,
			'flex-width' => true,
			'flex-height' => false,
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
	add_theme_support(
		'custom-background',
		array(
			'wp-head-callback' => 'zan_custom_background_cb'
		)
	);

	load_theme_textdomain('zanblog-plus', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'zan_setup');

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
 * Prevent search engine web crawlers from indexing a password protected post or a none content page.
 */
if (version_compare($GLOBALS['wp_version'], '5.7', '<')) :
	function zan_no_robots()
	{
		if ((!have_posts() || is_single() && post_password_required()) && get_option('blog_public')) {
			wp_no_robots();
		}
	}
	add_action('wp_head', 'zan_no_robots', 1);
else :
	function zan_no_robots($robots)
	{
		if ((!have_posts() || is_single() && post_password_required()) && get_option('blog_public')) {
			return wp_robots_no_robots($robots);
		}
		return $robots;
	}
	add_filter('wp_robots', 'zan_no_robots');
endif;

/**
 * Enqueues scripts and styles.
 */
function zan_scripts()
{
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.4.1');

	wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.min.css', array(), '5.13.0');

	// Theme stylesheet.
	wp_enqueue_style('zan-style', get_stylesheet_uri(), array(), '20210706');

	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.4.1', true);

	wp_enqueue_script('zan-script', get_template_directory_uri() . '/assets/js/zanblog.js', array('jquery'), '20210410', true);
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

	if (is_page_template('page-templates/full-width.php')) {
		if ($width >= 1100) {
			$sizes = '(max-width: 768px) 89vw, (max-width: 992px) 680px, (max-width: 1200px) 900px, 1100px';
		} elseif ($width >= 900) {
			$sizes = '(max-width: 768px) 89vw, (max-width: 992px) 680px, (max-width: 1200px) 900px, ' . $width . 'px';
		} elseif ($width >= 680) {
			$sizes = '(max-width: 768px) 89vw, (max-width: 992px) 680px, ' . $width . 'px';
		} else {
			$sizes = '(max-width: ' . ($width / 0.89) . 'px) 89vw, ' . $width . 'px';
		}
	} else {
		if ($width >= 710) {
			$sizes = '(max-width: 768px) 89vw, (max-width: 992px) 680px, (max-width: 1200px) 576px, 710px';
		} elseif ($width >= 680) {
			$sizes = '(max-width: 768px) 89vw, (max-width: 992px) 680px, (max-width: 1200px) 576px, ' . $width . 'px';
		} elseif ($width >= 576) {
			$sizes = '(max-width: ' . ($width / 0.89) . 'px) 89vw, (max-width: 992px) ' . $width . 'px, (max-width: 1200px) 576px, ' . $width . 'px';
		} else {
			$sizes = '(max-width: ' . ($width / 0.89) . 'px) 89vw, ' . $width . 'px';
		}
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
		if (is_page_template('page-templates/full-width.php')) {
			$attr['sizes'] = '(max-width: 768px) 89vw, (max-width: 992px) 680px, (max-width: 1200px) 900px, 1100px';
		} else {
			$attr['sizes'] = '(max-width: 768px) 89vw, (max-width: 992px) 680px, (max-width: 1200px) 576px, 710px';
		}
	}
	return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'zan_post_thumbnail_sizes_attr', 10, 3);

if (class_exists('\\Smush\\Core\\Settings') && \Smush\Core\Settings::get_instance()->get('lazy_load')) :

	if (version_compare($GLOBALS['wp_version'], '5.5', '<')) :
		// Modify from wp_image_add_srcset_and_sizes()
		function zan_image_add_width_and_height($image, $image_meta, $attachment_id)
		{
			$image_src = preg_match('/ src="([^"]+)"/', $image, $match_src) ? $match_src[1] : '';
			list($image_src) = explode('?', $image_src);

			// Return early if we couldn't get the image source.
			if (!$image_src) {
				return $image;
			}

			$width = 0;
			$height = 0;

			$image_filename = wp_basename($image_src);
			if ($image_meta && wp_basename($image_meta['file']) === $image_filename) {
				$width  = (int) $image_meta['width'];
				$height = (int) $image_meta['height'];
			} else if (!empty($image_meta['sizes'])) {
				foreach ($image_meta['sizes'] as $image_size_data) {
					if ($image_filename === $image_size_data['file']) {
						$width  = (int) $image_size_data['width'];
						$height = (int) $image_size_data['height'];
						break;
					}
				}
			}

			if (!$width || !$height) {
				return $image;
			}

			if (strpos($image, ' width=') === false && strpos($image, ' height=') === false) {
				return str_replace('<img ', '<img width="' . $width . '" height="' . $height . '" ', $image);
			}
		}

		// Modify from wp_make_content_images_responsive()
		function zan_content_images_add_width_and_height($content)
		{
			if (!preg_match_all('/<img [^>]+>/', $content, $matches)) {
				return $content;
			}

			$selected_images = array();
			$attachment_ids  = array();

			foreach ($matches[0] as $image) {
				if (preg_match('/wp-image-([0-9]+)/i', $image, $class_id)) {
					$attachment_id = absint($class_id[1]);

					if ($attachment_id) {
						/*
						* If exactly the same image tag is used more than once, overwrite it.
						* All identical tags will be replaced later with 'str_replace()'.
						*/
						$selected_images[$image] = $attachment_id;
						// Overwrite the ID when the same image is included more than once.
						$attachment_ids[$attachment_id] = true;
					}
				}
			}
			if (count($attachment_ids) > 1) {
				/*
				* Warm the object cache with post and meta information for all found
				* images to avoid making individual database calls.
				*/
				_prime_post_caches(array_keys($attachment_ids), false, true);
			}

			foreach ($selected_images as $image => $attachment_id) {
				$image_meta = wp_get_attachment_metadata($attachment_id);
				$content = str_replace($image, zan_image_add_width_and_height($image, $image_meta, $attachment_id), $content);
			}
			return $content;
		}
		add_filter('the_content', 'zan_content_images_add_width_and_height', 20);
	endif;

	// code part from https://stackoverflow.com/questions/23416880/lazy-loading-with-responsive-images-unknown-height#answer-60396260
	function zan_footer_lazyload_javascript()
	{ ?>
		<script>
			jQuery('.lazyload').each(function(i, e) {
				var img = jQuery(e);
				var h = img.attr('height');
				var w = img.attr('width');
				if (w && h) {
					img.attr('src', "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 " +
						w + " " + h + "'%3E%3C/svg%3E");
				}
			});
		</script>
	<?php
	}
	add_action('wp_print_footer_scripts', 'zan_footer_lazyload_javascript', 5);

endif;

function zan_breadcrumb($is_block = true)
{
	if (function_exists('bcn_display')) :
	?>
		<div class="breadcrumb<?php if ($is_block) echo ' panel panel-default'; ?>" itemscope itemtype="https://schema.org/BreadcrumbList">
			<i class="fas fa-home"></i> <?php bcn_display(); ?>
		</div>
<?php
	endif;
}

function zan_nav_menu_submenu_css_class($classes, $args, $depth)
{
	if ($args->theme_location == 'top') {
		$classes[] = 'dropdown-menu';
	}
	return $classes;
}
add_filter('nav_menu_submenu_css_class', 'zan_nav_menu_submenu_css_class', 10, 3);

/**
 * Custom password protected post's title prefix.
 */
function zan_protected_title_format()
{
	if (post_password_required()) {
		return '<i class="fas fa-lock"></i> %s';
	} else {
		return '<i class="fas fa-lock-open"></i> %s';
	}
}
add_filter('protected_title_format', 'zan_protected_title_format');

/**
 * Custom private post's title prefix.
 */
function zan_private_title_format()
{
	return '<i class="fas fa-eye-slash"></i> %s';
}
add_filter('private_title_format', 'zan_private_title_format');

/**
 * Retrieve protected post password form content.
 *
 * @since ZanBlog Plus 1.2
 *
 * @param string $output The password form HTML output.
 * @return string HTML content for password form for password protected post.
 */
function zan_password_form($output)
{
	if (preg_match('/<label for="(.*?)">/', $output, $matches)) {
		$label = $matches[1];
	} else {
		$label  = 'pwbox-' . wp_rand();
	}
	$output = '<p>' . __('This content is password protected. To view it please enter your password below:') . '</p>'
		. '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form" method="post">'
		. '<div><label for="' . $label . '" class="screen-reader-text">' . __('Password:') . '</label></div><div class="input-group">'
		. '<input name="post_password" id="' . $label . '" class="post-password-field form-control" type="password" size="20" placeholder="' . __('Password') . '" />'
		. '<span class="input-group-btn"><button type="submit" class="post-password-submit btn btn-danger" name="Submit">' . esc_attr_x('Enter', 'post password form') . '</button></span>'
		. '</div></form>';
	return $output;
}
add_filter('the_password_form', 'zan_password_form');

function exclude_password_proceted($query)
{
	if ($query->is_home() && $query->is_main_query()) {
		$query->set('has_password', false);
	}
}
add_action('pre_get_posts', 'exclude_password_proceted');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom widget functions for this theme.
 */
require get_template_directory() . '/inc/widget-functions.php';

/**
 * Custom comment functions for this theme.
 */
require get_template_directory() . '/inc/comment-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

// command to make i18n pot file
// wp i18n make-pot . ./languages/zanblog-plus.pot