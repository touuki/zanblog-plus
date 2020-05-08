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
		'title'			=> __('Content', 'default'),
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
		'label'			=> __('Post copyright (HTML code).', 'default'),
		'section'		=> 'content',
		'priority'		=> 10,
		'type'          => 'textarea',
	));

	$wp_customize->add_setting('disable_wptexturize');

	$wp_customize->add_control('disable_wptexturize', array(
		'label'      => __('Disable texturize', 'default'),
		'description'=> _x('If true, it will short-circuit wptexturize() and display the original text. See <a href="https://developer.wordpress.org/reference/functions/wptexturize/" target="_blank" rel="noreferrer noopener">wptexturize()</a>', 'disable_wptexturize', 'default'),
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

function add_theme_copyright_page() {
    add_theme_page( __('Copyright', 'default'), __('Copyright', 'default'), 'edit_theme_options', add_query_arg( 
		array( 
			'return' => urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 
			'autofocus' => array( 'control' => 'copyright_post' ),
		), 'customize.php' ) );
}
add_action( 'admin_menu', 'add_theme_copyright_page' );

function zan_run_wptexturize($run_texturize) {
	if(get_theme_mod('disable_wptexturize')){
		return false;
	} else {
		return $run_texturize;
	}
}
add_filter('run_wptexturize', 'zan_run_wptexturize');

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