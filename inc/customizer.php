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

	$wp_customize->add_section('copyright', array(
		'title'			=> __('Copyright', 'default'),
		'priority'		=> 100,
	));
	
	if (get_option('copyright_post') === false) {
		$default_copyright_post = '<p><strong>Author</strong>: <a href="%AUTHOR_URL%">%POST_AUTHOR%</a></p>
		<p><strong>Title</strong>: %POST_TITLE%</p>
		<p><strong>URL</strong>: <a href="%POST_URL%" rel="bookmark">%POST_URL%</a></p>
		<p>If you find this article helpful, you are welcome to reprint it following the license below, with source credited.</p>
		<p><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a>
		<span>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.</span></p>';
		add_option('copyright_post', $default_copyright_post);
	}

	$wp_customize->add_setting(
		'copyright_post',
		array(
			'type'			=> 'option',
			'transport'     => 'postMessage',
		)
	);

	$wp_customize->add_control('copyright_post', array(
		'label'			=> __('Post copyright (HTML code).', 'default'),
		'section'		=> 'copyright',
		'priority'		=> 10,
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
    add_theme_page( __('Copyright', 'default'), __('Copyright', 'default'), 'edit_theme_options', 'customize.php?return=%2Fwordpress%2Fwp-admin%2Fplugins.php%3Fplugin_status%3Dall%26paged%3D1%26s&autofocus%5Bcontrol%5D=copyright_post' );
}
add_action( 'admin_menu', 'add_theme_copyright_page' );