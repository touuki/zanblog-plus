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
include get_parent_theme_file_path('/widgets/zan-widget-search.php');
include get_parent_theme_file_path('/widgets/zan-widget-hotest-posts.php');
include get_parent_theme_file_path('/widgets/zan-widget-latest-posts.php');
include get_parent_theme_file_path('/widgets/zan-widget-rand-posts.php');
include get_parent_theme_file_path('/widgets/zan-widget-latest-comments.php');
include get_parent_theme_file_path('/widgets/zan-widget-login.php');
include get_parent_theme_file_path('/widgets/zan-widget-ad.php');
include get_parent_theme_file_path('/widgets/zan-widget-custom.php');
include get_parent_theme_file_path('/widgets/zan-widget-sets.php');
include get_parent_theme_file_path('/widgets/zan-widget-link.php');

// 注销系统默认小工具
add_action('widgets_init', 'zan_deregister_widgets');

add_action('widgets_init', 'zan_register_widgets');

// 注册自定义小工具侧边栏
add_action('widgets_init', 'zan_register_sidebar');


/**
 * 系统默认小工具注销
 *
 * @since Zanblog 3.0.0
 * @return void
 */
function zan_deregister_widgets()
{
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Categories');
}

function zan_register_widgets()
{
	register_widget('Zan_Ad');
	register_widget('Zan_Custom');
	register_widget('Zan_Hotest_Posts');
	register_widget('Zan_Latest_Comments');
	register_widget('Zan_Latest_Posts');
	register_widget('Zan_Link');
	register_widget('Zan_Login');
	register_widget('Zan_Rand_Posts');
	register_widget('Zan_Search');
	register_widget('Zan_Sets');
}

/**
 * 注册自定义小工具侧边栏
 *
 * @since Zanblog 2.0.0
 * @return void
 */
function zan_register_sidebar()
{
	if (function_exists('register_sidebar')) {

		register_sidebar(array(
			'id'            => 'index-sidebar',
			'name'          => '首页侧边栏',
			'description'   => '首页侧边栏，只有首页可见',
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>'
		));

		register_sidebar(array(
			'id'            => 'single-sidebar',
			'name'          => '文章侧边栏',
			'description'   => '文章侧边栏，只有single页面可见',
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>'
		));

		register_sidebar(array(
			'id'            => 'archive-sidebar',
			'name'          => '归档侧边栏',
			'description'   => '归档侧边栏，包括分类、标签、作者、归档等页面',
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>'
		));

		register_sidebar(array(
			'id'            => 'page-sidebar',
			'name'          => '页面侧边栏',
			'description'   => '页面侧边栏，只有页面可见',
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>'
		));

		register_sidebar(array(
			'id'            => 'slide-sidebar',
			'name'          => '幻灯片位置',
			'description'   => '只放置幻灯片',
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>'
		));
	}
}
