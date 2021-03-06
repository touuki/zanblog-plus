<?php

/**
 * ZanBlog Plus: Customizer
 *
 * @package ZanBlog_Plus
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
		'disable_wptexturize',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control('disable_wptexturize', array(
		'label'      => __('Disable texturize', 'zanblog-plus'),
		'description' => __('If checked, it will short-circuit wptexturize() and display the original text. See <a href="https://developer.wordpress.org/reference/functions/wptexturize/" target="_blank" rel="noreferrer noopener">wptexturize()</a>', 'zanblog-plus'),
		'priority'   => 20,
		'type'       => 'checkbox',
		'section'    => 'content'
	));

	$wp_customize->add_setting(
		'disable_content_images_responsive',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control('disable_content_images_responsive', array(
		'label'      => __('Disable content images responsive', 'zanblog-plus'),
		'description' => __('If checked, it will disable images responsive in the post content. Sometime the responsive images are larger than the original images, and there is no benefit in these cases.', 'zanblog-plus'),
		'priority'   => 30,
		'type'       => 'checkbox',
		'section'    => 'content'
	));

	$wp_customize->add_setting(
		'rich_comment_editor',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control('rich_comment_editor', array(
		'label'      => __('Enable rich comment editor', 'zanblog-plus'),
		'description' => __('Use TinyMCE in comment form', 'zanblog-plus'),
		'priority'   => 35,
		'type'       => 'checkbox',
		'section'    => 'content'
	));

	$wp_customize->add_setting(
		'always_use_twemoji',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control('always_use_twemoji', array(
		'label'      => __('Always use Twemoji', 'zanblog-plus'),
		'description' => __('Always use <a href="https://twemoji.twitter.com/" target="_blank" rel="noreferrer noopener">Twemoji</a> to show Emoji characters.', 'zanblog-plus'),
		'priority'   => 40,
		'type'       => 'checkbox',
		'section'    => 'content'
	));

	$wp_customize->add_setting(
		'copyright_post',
		array(
			'type'			=> 'option',
			'transport'     => 'postMessage',
			'sanitize_callback' => 'wp_kses_normalize_entities',
		)
	);

	$wp_customize->add_control('copyright_post', array(
		'label'			=> __('Post copyright', 'zanblog-plus'),
		'description'   => __('Accept any HTML content. Allowed Variables: %POST_TITLE%, %POST_URL%, %POST_DATE%, %POST_TIME%, %POST_AUTHOR%, %AUTHOR_URL%, %BLOG_NAME%, %BLOG_URL%', 'zanblog-plus'),
		'section'		=> 'content',
		'priority'		=> 90,
		'type'          => 'textarea',
	));

	$wp_customize->add_setting(
		'analytics_script',
		array(
			'type'			=> 'option',
			'sanitize_callback' => 'wp_kses_normalize_entities',
		)
	);

	$wp_customize->add_control('analytics_script', array(
		'label'			=> __('Analytics script', 'zanblog-plus'),
		'description'   => __('Accept any HTML content and insert it in <code>&lt;head&gt;</code> tag.', 'zanblog-plus'),
		'section'		=> 'content',
		'priority'		=> 100,
		'type'          => 'textarea',
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

function zan_analytics_script(){
	echo get_option('analytics_script');
}
add_action('wp_head', 'zan_analytics_script', 1000);

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
	return __('<p><strong>Author</strong>: <a href="%AUTHOR_URL%">%POST_AUTHOR%</a></p>
	<p><strong>Title</strong>: %POST_TITLE%</p>
	<p><strong>URL</strong>: <a href="%POST_URL%" rel="bookmark">%POST_URL%</a></p>
	<p>If you find this article helpful, you are welcome to reprint it following the license below, with source credited.</p>
	<p><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://licensebuttons.net/l/by-nc-sa/4.0/88x31.png" /></a>
	<span>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.</span></p>', 'zanblog-plus');
}

add_filter('default_option_copyright_post', 'zan_default_option_copyright_post');

function add_theme_content_page()
{
	add_theme_page(__('Content setting', 'zanblog-plus'), __('Content setting', 'zanblog-plus'), 'edit_theme_options', add_query_arg(
		array(
			'return' => urlencode(remove_query_arg(wp_removable_query_args(), wp_unslash($_SERVER['REQUEST_URI']))),
			'autofocus' => array('section' => 'content'),
		),
		'customize.php'
	));
}
add_action('admin_menu', 'add_theme_content_page');

if (get_theme_mod('disable_wptexturize')) :
	function zan_document_title_separator($sep)
	{
		return '–'; // U+2013
	}
	add_filter('document_title_separator', 'zan_document_title_separator');
	add_filter('run_wptexturize', '__return_false');
endif;

if (get_theme_mod('disable_content_images_responsive')) :
	if (version_compare($GLOBALS['wp_version'], '5.5', '<')) {
		remove_filter('the_content', 'wp_make_content_images_responsive');
	} else {
		add_filter('wp_img_tag_add_srcset_and_sizes_attr', '__return_false');
	}
endif;

if (get_theme_mod('always_use_twemoji')) :
	function zan_always_use_twemoji()
	{ ?>
		<script>
			if (typeof _wpemojiSettings !== 'undefined')
				_wpemojiSettings.supports = {
					everything: false,
					everythingExceptFlag: false,
					flag: false,
					emoji: false
				}
		</script>
	<?php
	}
	add_action('wp_print_footer_scripts', 'zan_always_use_twemoji');
endif;

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
