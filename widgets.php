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
include get_parent_theme_file_path('/widgets/zan-widget-hotest-posts.php');
include get_parent_theme_file_path('/widgets/zan-widget-latest-posts.php');
include get_parent_theme_file_path('/widgets/zan-widget-rand-posts.php');
include get_parent_theme_file_path('/widgets/zan-widget-latest-comments.php');
include get_parent_theme_file_path('/widgets/zan-widget-login.php');
include get_parent_theme_file_path('/widgets/zan-widget-custom.php');

add_action('widgets_init', 'zan_register_widgets');

function zan_register_widgets()
{
	register_widget('Zan_Custom');
	register_widget('Zan_Hotest_Posts');
	register_widget('Zan_Latest_Comments');
	register_widget('Zan_Latest_Posts');
	register_widget('Zan_Login');
	register_widget('Zan_Rand_Posts');
}

