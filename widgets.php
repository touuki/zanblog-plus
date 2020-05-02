<?php

/**
 * ZanBlog 小工具函数加载与操作
 *
 * @package 	  ZanBlog
 * @subpackage  Include
 * @since 		  2.1.0
 * @author      YEAHZAN
 */

// 加载小工具组件
include get_parent_theme_file_path('/widgets/zan-widget-rand-posts.php');
include get_parent_theme_file_path('/widgets/class-zan-widget-recent-comments.php');

add_action('widgets_init', 'zan_register_widgets', 1);

function zan_register_widgets()
{
	unregister_widget('WP_Widget_Recent_Comments');
	register_widget('Zan_Widget_Recent_Comments');

	register_widget('Zan_Rand_Posts');
}

