<?php

require get_template_directory() . '/widgets/class-zan-widget-recent-comments.php';
function zan_register_widgets(){
	unregister_widget('WP_Widget_Recent_Comments');
	register_widget('Zan_Widget_Recent_Comments');
}
add_action('widgets_init', 'zan_register_widgets');

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


if (version_compare($GLOBALS['wp_version'], '4.9.0', '>=')) {
	/**
	 * Add a method to use WP_Widget_Recent_Posts to show random posts.
     * Just add 'i$random-posts$' in the widget title and it will not display on the front.
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
 * Custom WP_PostViews Widget and template.
 */
function zan_option_views_options($value)
{
	$value['template'] = '%VIEW_COUNT%';
	$value['most_viewed_template'] = '<li><a href="%POST_URL%" title="%POST_TITLE%">%POST_TITLE%</a><span class="badge"><i class="fa fa-eye"></i> %VIEW_COUNT%</span></li>';
	return $value;
}
add_filter('option_views_options', 'zan_option_views_options');


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
add_filter('wp_tag_cloud', 'zan_color_cloud');

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


function zan_get_calendar($calendar_output){
    return str_replace('class="wp-calendar-table"','class="wp-calendar-table table table-striped table-condensed"',$calendar_output);
}
add_filter('get_calendar', 'zan_get_calendar');