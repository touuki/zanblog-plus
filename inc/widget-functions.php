<?php
/**
 * Widget functions and definitions
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

require get_template_directory() . '/widgets/class-zan-widget-recent-comments.php';
function zan_register_widgets()
{
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
		'name'          => __('Blog Sidebar', 'zanblog-plus'),
		'description'   => __('Add widgets here to appear in your blog sidebar.', 'zanblog-plus'),
		'before_widget' => '<section id="%1$s" class="panel panel-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="panel-heading"><h2 class="widgettitle">',
		'after_title'   => '</h2><i class="fas fa-times-circle panel-btn-remove"></i><i class="fas fa-chevron-circle-up panel-btn-toggle"></i></div>',
	));

	register_sidebar(array(
		'id'            => 'sidebar-2',
		'name'          => __('Head Banner', 'zanblog-plus'),
		'description'   => __('Add widgets here to appear in your head banner (before the posts).', 'zanblog-plus'),
		'before_widget' => '<section id="%1$s" class="panel panel-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="panel-heading"><h2 class="widgettitle">',
		'after_title'   => '</h2><i class="fas fa-times-circle panel-btn-remove"></i><i class="fas fa-chevron-circle-up panel-btn-toggle"></i></div>',
	));
}
add_action('widgets_init', 'zan_widgets_init');


/**
 * Add Font Awesome support in widget title.
 * A title like 'i$fas fa-sync-alt$ Title' will be replaced with '<i class="fas fa-sync-alt"></i>  Title'
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

function zan_widget_display_callback($instance, $widget, $args)
{
	if (is_home()) {
		return isset($instance['hide_on_home']) && $instance['hide_on_home'] ? false : $instance;
	}
	if (is_single()) {
		return isset($instance['hide_on_post']) && $instance['hide_on_post'] ? false : $instance;
	}
	if (is_page()) {
		return isset($instance['hide_on_page']) && $instance['hide_on_page'] ? false : $instance;
	}
	return isset($instance['hide_on_other']) && $instance['hide_on_other'] ? false : $instance;
}
add_filter('widget_display_callback', 'zan_widget_display_callback', 10, 3);

function zan_widget_update_callback($instance, $new_instance, $old_instance, $widget)
{
	$instance['hide_on_home'] = isset($new_instance['hide_on_home']) ? (bool) $new_instance['hide_on_home'] : false;
	$instance['hide_on_post'] = isset($new_instance['hide_on_post']) ? (bool) $new_instance['hide_on_post'] : false;
	$instance['hide_on_page'] = isset($new_instance['hide_on_page']) ? (bool) $new_instance['hide_on_page'] : false;
	$instance['hide_on_other'] = isset($new_instance['hide_on_other']) ? (bool) $new_instance['hide_on_other'] : false;
	return $instance;
}
add_filter('widget_update_callback', 'zan_widget_update_callback', 10, 4);

function zan_widget_form_callback($instance, $widget)
{
	$hide_on_home = isset($instance['hide_on_home']) ? (bool) $instance['hide_on_home'] : false;
	$hide_on_post = isset($instance['hide_on_post']) ? (bool) $instance['hide_on_post'] : false;
	$hide_on_page = isset($instance['hide_on_page']) ? (bool) $instance['hide_on_page'] : false;
	$hide_on_other = isset($instance['hide_on_other']) ? (bool) $instance['hide_on_other'] : false;
?>
	<p>
		<?php _ex('Hide on:', 'hidden_widget', 'zanblog-plus') ?>
		<label for="<?php echo $widget->get_field_id('hide_on_home'); ?>"><?php _ex('Home', 'hidden_widget', 'zanblog-plus'); ?></label>
		<input class="checkbox" type="checkbox" <?php checked($hide_on_home); ?> id="<?php echo $widget->get_field_id('hide_on_home'); ?>" name="<?php echo $widget->get_field_name('hide_on_home'); ?>" />
		<label for="<?php echo $widget->get_field_id('hide_on_post'); ?>"><?php _ex('Post', 'hidden_widget', 'zanblog-plus'); ?></label>
		<input class="checkbox" type="checkbox" <?php checked($hide_on_post); ?> id="<?php echo $widget->get_field_id('hide_on_post'); ?>" name="<?php echo $widget->get_field_name('hide_on_post'); ?>" />
		<label for="<?php echo $widget->get_field_id('hide_on_page'); ?>"><?php _ex('Page', 'hidden_widget', 'zanblog-plus'); ?></label>
		<input class="checkbox" type="checkbox" <?php checked($hide_on_page); ?> id="<?php echo $widget->get_field_id('hide_on_page'); ?>" name="<?php echo $widget->get_field_name('hide_on_page'); ?>" />
		<label for="<?php echo $widget->get_field_id('hide_on_other'); ?>"><?php _ex('Other', 'hidden_widget', 'zanblog-plus'); ?></label>
		<input class="checkbox" type="checkbox" <?php checked($hide_on_other); ?> id="<?php echo $widget->get_field_id('hide_on_other'); ?>" name="<?php echo $widget->get_field_name('hide_on_other'); ?>" />
	</p>
<?php
	return $instance;
}
add_filter('widget_form_callback', 'zan_widget_form_callback', 10, 2);

/**
 * Custom WP_PostViews Widget and template.
 */
function zan_option_views_options($value)
{
	$value['template'] = '%VIEW_COUNT%';
	$value['most_viewed_template'] = '<li><a href="%POST_URL%">%POST_TITLE%</a><span class="badge"><i class="fas fa-eye"></i> %VIEW_COUNT%</span></li>';
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


function zan_get_calendar($calendar_output)
{
	return str_replace('class="wp-calendar-table"', 'class="wp-calendar-table table table-striped table-condensed"', $calendar_output);
}
add_filter('get_calendar', 'zan_get_calendar');


add_filter('show_recent_comments_widget_style', '__return_false');

function zan_comment_excerpt_length($comment_excerpt_length){
	return 70;
}
add_filter('comment_excerpt_length', 'zan_comment_excerpt_length');