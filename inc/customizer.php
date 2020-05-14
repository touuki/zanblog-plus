<?php

/**
 * ZanBlog Plus: Customizer
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zan_customize_register($wp_customize)
{

	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';

	$wp_customize->add_section('content', array(
		'title'			=> __('Content setting', 'zanblog-plus'),
		'priority'		=> 100,
	));

	$wp_customize->add_setting(
		'copyright_post',
		array(
			'type'			=> 'option',
			'transport'     => 'postMessage',
		)
	);

	$wp_customize->add_control('copyright_post', array(
		'label'			=> __('Post copyright', 'zanblog-plus'),
		'description'   => __('Accept any HTML content.', 'zanblog-plus'),
		'section'		=> 'content',
		'priority'		=> 10,
		'type'          => 'textarea',
	));

	$wp_customize->add_setting('disable_wptexturize');

	$wp_customize->add_control('disable_wptexturize', array(
		'label'      => __('Disable texturize', 'zanblog-plus'),
		'description' => _x('If true, it will short-circuit wptexturize() and display the original text. See <a href="https://developer.wordpress.org/reference/functions/wptexturize/" target="_blank" rel="noreferrer noopener">wptexturize()</a>', 'disable_wptexturize', 'zanblog-plus'),
		'priority'   => 10,
		'type'       => 'checkbox',
		'section'    => 'content'
	));

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'            => '.site-title',
				'container_inclusive' => false,
				'render_callback'     => 'zan_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'zan_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'copyright_post',
			array(
				'selector'            => '.copyright-post',
				'container_inclusive' => false,
				'render_callback'     => 'zan_copyright_post',
			)
		);
	}
}
add_action('customize_register', 'zan_customize_register');


/**
 * Render the site title for the selective refresh partial.
 *
 * @since ZanBlog Plus 1.0
 * @see zan_customize_register()
 *
 * @return void
 */
function zan_customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since ZanBlog Plus 1.0
 * @see zan_customize_register()
 *
 * @return void
 */
function zan_customize_partial_blogdescription()
{
	bloginfo('description');
}

function zan_copyright_post()
{
	$output = stripslashes(get_option('copyright_post'));
	$output = str_replace('%POST_TITLE%', get_the_title(), $output);
	$output = str_replace('%POST_URL%', esc_url(get_permalink()), $output);
	$output = str_replace('%POST_DATE%', get_the_date(), $output);
	$output = str_replace('%POST_TIME%', get_the_time(), $output);
	$output = str_replace('%POST_AUTHOR%', get_the_author(), $output);
	$output = str_replace('%AUTHOR_URL%', esc_url(get_author_posts_url(get_the_author_meta('ID'))), $output);
	$output = str_replace('%BLOG_NAME%', get_bloginfo('name'), $output);
	$output = str_replace('%BLOG_URL%', esc_url(get_home_url('/')), $output);
	echo $output;
}

function zan_default_option_copyright_post($default)
{
	return '<p><strong>Author</strong>: <a href="%AUTHOR_URL%">%POST_AUTHOR%</a></p>
	<p><strong>Title</strong>: %POST_TITLE%</p>
	<p><strong>URL</strong>: <a href="%POST_URL%" rel="bookmark">%POST_URL%</a></p>
	<p>If you find this article helpful, you are welcome to reprint it following the license below, with source credited.</p>
	<p><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://licensebuttons.net/l/by-nc-sa/4.0/88x31.png" /></a>
	<span>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.</span></p>';
}

add_filter('default_option_copyright_post', 'zan_default_option_copyright_post');

function add_theme_copyright_page()
{
	add_theme_page(__('Copyright', 'zanblog-plus'), __('Copyright', 'zanblog-plus'), 'edit_theme_options', add_query_arg(
		array(
			'return' => urlencode(remove_query_arg(wp_removable_query_args(), wp_unslash($_SERVER['REQUEST_URI']))),
			'autofocus' => array('control' => 'copyright_post'),
		),
		'customize.php'
	));
}
add_action('admin_menu', 'add_theme_copyright_page');

function zan_document_title_separator($sep)
{
	return '–';
}

function zan_run_wptexturize($run_texturize)
{
	if (get_theme_mod('disable_wptexturize')) {
		add_filter('document_title_separator', 'zan_document_title_separator');
		return false;
	} else {
		return $run_texturize;
	}
}
add_filter('run_wptexturize', 'zan_run_wptexturize');
//Reset wptexturize in case the wptexturize is first called before the filter is added.
wptexturize('Any non-empty text', true);

/**
 * Modified from wp-includes/theme.php/_custom_background_cb(). The default callback function cannot show fixed background on iOS browser.
 *
 * @see _custom_background_cb()
 */
function zan_custom_background_cb()
{
	global $is_IE;
	if ($is_IE) {
		// if IE, back to default callback function
		return _custom_background_cb();
	}

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
