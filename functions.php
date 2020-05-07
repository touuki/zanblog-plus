<?php

/**
 * ZanBlog Plus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
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
			'top'    => __('Top Menu', 'default'),
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

	if (get_option('copyright_post') === false) {
		$default_copyright_post = '<p><strong>Author</strong>: <a href="%AUTHOR_URL%">%POST_AUTHOR%</a></p>
		<p><strong>Title</strong>: %POST_TITLE%</p>
		<p><strong>URL</strong>: <a href="%POST_URL%" rel="bookmark">%POST_URL%</a></p>
		<p>If you find this article helpful, you are welcome to reprint it following the license below, with source credited.</p>
		<p><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://licensebuttons.net/l/by-nc-sa/4.0/88x31.png" /></a>
		<span>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.</span></p>';
		add_option('copyright_post', $default_copyright_post);
	}
}
add_action('after_setup_theme', 'zan_setup');

/**
 * Modified from wp-includes/theme.php/_custom_background_cb(). The default callback function cannot show fixed background on iOS browser.
 *
 * @see _custom_background_cb()
 */
function zan_custom_background_cb()
{
	$attachment = get_theme_mod('background_attachment', get_theme_support('custom-background', 'default-attachment'));

	if ('fixed' !== $attachment) {
		// if not fixed, back to default callback function
		return _custom_background_cb();
	}

	// $background is the saved custom image, or the default image.
	$background = set_url_scheme(get_background_image());

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if (get_theme_support('custom-background', 'default-color') === $color) {
		$color = false;
	}

	$type_attr = current_theme_supports('html5', 'style') ? '' : ' type="text/css"';

	if (!$background && !$color) {
		if (is_customize_preview()) {
			printf('<style%s id="custom-background-css"></style>', $type_attr);
		}
		return;
	}

	$style = $color ? "background-color: #$color;" : '';

	if ($background) {
		$image = ' background-image: url("' . esc_url_raw($background) . '");';

		// Background Position.
		$position_x = get_theme_mod('background_position_x', get_theme_support('custom-background', 'default-position-x'));
		$position_y = get_theme_mod('background_position_y', get_theme_support('custom-background', 'default-position-y'));

		if (!in_array($position_x, array('left', 'center', 'right'), true)) {
			$position_x = 'left';
		}

		if (!in_array($position_y, array('top', 'center', 'bottom'), true)) {
			$position_y = 'top';
		}

		$position = " background-position: $position_x $position_y;";

		// Background Size.
		$size = get_theme_mod('background_size', get_theme_support('custom-background', 'default-size'));

		if (!in_array($size, array('auto', 'contain', 'cover'), true)) {
			$size = 'auto';
		}

		$size = " background-size: $size;";

		// Background Repeat.
		$repeat = get_theme_mod('background_repeat', get_theme_support('custom-background', 'default-repeat'));

		if (!in_array($repeat, array('repeat-x', 'repeat-y', 'repeat', 'no-repeat'), true)) {
			$repeat = 'repeat';
		}

		$repeat = " background-repeat: $repeat;";

		$style .= $image . $position . $size . $repeat;
	}
?>
	<style <?php echo $type_attr; ?> id="custom-background-css">
		body.custom-background {
			/* To be compatible with IE */
			background-attachment: fixed;
			<?php echo trim($style); ?>
		}

		body.custom-background:before {
			content: '';
			position: fixed;
			z-index: -1;
			top: 0;
			right: 0;
			height: 100vh;
			left: 0;
			<?php echo trim($style); ?>
		}
	</style>
	<?php
}

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
function zan_noindex()
{
	if ((!have_posts() || post_password_required()) && get_option('blog_public')) {
		wp_no_robots();
	}
}
add_action('wp_head', 'zan_noindex', 1);

/**
 * Enqueues scripts and styles.
 */
function zan_scripts()
{
	//wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), null);

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.4.1');

	wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.min.css', array(), '5.13.0');

	// Theme stylesheet.
	wp_enqueue_style('zan-style', get_stylesheet_uri(), array(), '1.0');

	//wp_deregister_script('jquery');
	//wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.0.min.js', array(), null);

	//wp_enqueue_script('popper.js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), null);

	//wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery', 'popper.js'), null);

	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.4.1');

	wp_enqueue_script('zan-script', get_template_directory_uri() . '/assets/js/zanblog.js', array('jquery'), '1.0');

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

function zan_comment_form()
{
	$req = get_option('require_name_email');
	$html_req = ($req ? " required='required'" : '');
	$commenter     = wp_get_current_commenter();

	$fields = array(
		'author' => sprintf(
			'<div class="row"><div class="col-sm-4">%s<div class="comment-form-author input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>%s</div></div>',
			sprintf(
				'<label class="screen-reader-text" for="author">%s%s</label>',
				__('Name'),
				($req ? ' <span class="required">*</span>' : '')
			),
			sprintf(
				'<input class="form-control" id="author" name="author" type="text" placeholder="%s" value="%s" size="30" maxlength="245"%s />',
				__('Name') . ($req ? '*' : ''),
				esc_attr($commenter['comment_author']),
				$html_req
			)
		),
		'email'  => sprintf(
			'<div class="col-sm-4">%s<div class="comment-form-email input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>%s</div></div>',
			sprintf(
				'<label class="screen-reader-text" for="email">%s%s</label>',
				__('Email'),
				($req ? ' <span class="required">*</span>' : '')
			),
			sprintf(
				'<input class="form-control" id="email" name="email" type="email" placeholder="%s" value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
				__('Email') . ($req ? '*' : ''),
				esc_attr($commenter['comment_author_email']),
				$html_req
			)
		),
		'url'    => sprintf(
			'<div class="col-sm-4">%s<div class="comment-form-url input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span>%s</div></div></div>',
			sprintf(
				'<label class="screen-reader-text" for="url">%s</label>',
				__('Website')
			),
			sprintf(
				'<input class="form-control" id="url" name="url" type="url" placeholder="%s" value="%s" size="30" maxlength="200" />',
				__('Website'),
				esc_attr($commenter['comment_author_url'])
			)
		),
	);

	comment_form(
		array(
			'title_reply'          => '<i class="fa fa-pen"></i> ' . __('Leave a Reply', 'default'),
			'fields'               => $fields,
			'class_submit' => 'submit btn btn-danger btn-block',
			'comment_field' => sprintf(
				'<p class="comment-form-comment">%s %s</p>',
				sprintf(
					'<label class="screen-reader-text" for="comment">%s</label>',
					_x('Comment', 'noun')
				),
				'<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>'
			),
			'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title alert alert-info">',
			'title_reply_after'    => '</h3>',
		)
	);
}

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
		return '<i class="fa fa-lock"></i> %s';
	} else {
		return '<i class="fa fa-lock-open"></i> %s';
	}
}
add_filter('protected_title_format', 'zan_protected_title_format');

/**
 * Custom private post's title prefix.
 */
function zan_private_title_format()
{
	return '<i class="fa fa-eye-slash"></i> %s';
}
add_filter('private_title_format', 'zan_private_title_format');

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
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
