<?php
/**
 * Functions 整体函数调用
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 2.1.0
 *
 */

// 自定义theme路径
define( 'THEMEPATH', TEMPLATEPATH . '/' );

// 自定义includes路径
define( 'INCLUDESEPATH', THEMEPATH . 'includes/' );

// 自定义widgets路径
define( 'WIDGETSPATH', INCLUDESEPATH . 'widgets/' );

// 自定义classes路径
define( 'CLASSESPATH', INCLUDESEPATH . 'classes/' );

// 自定义admin路径
define( 'ADMINPATH', INCLUDESEPATH . 'admin/' );

// 加载主题函数文件
require_once( INCLUDESEPATH . 'theme-functions.php' );

// 加载小工具文件
require_once( WIDGETSPATH . 'widgets.php' );

// 加载主题选项文件
require_once(INCLUDESEPATH . 'theme-options.php');

// 加载短代码文件
require_once(INCLUDESEPATH . 'shortcodes.php');

// 加载自定义登录文件
require_once(ADMINPATH . 'custom-login.php');

// 加载自定义用户资料文件
require_once(ADMINPATH . 'custom-user.php');

?>