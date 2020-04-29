<?php
/**
 * Functions 整体函数调用
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 2.1.0
 *
 */

// 加载主题函数文件
require get_parent_theme_file_path('/inc/theme-functions.php');

// 加载小工具文件
require get_parent_theme_file_path('/widgets.php');

// 加载主题选项文件
require get_parent_theme_file_path('/inc/theme-options.php');

// 加载短代码文件
require get_parent_theme_file_path('/inc/shortcodes.php');

// 加载自定义登录文件
require get_parent_theme_file_path('/inc/admin/custom-login.php');

// 加载自定义用户资料文件
require get_parent_theme_file_path('/inc/admin/custom-user.php');

function zan_breadcrumb($is_single = false){
    if (function_exists('bcn_display')) : ?>
		<!-- 面包屑 -->
		<div class="breadcrumb <?php if(!$is_single) echo 'zan-breadcrumb'; ?>">
			<i class="fa fa-home"></i>
			<?php bcn_display(); ?>
		</div>
		<!-- 面包屑结束 -->
	<?php endif;
}