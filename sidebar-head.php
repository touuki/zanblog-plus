<?php

/**
 * The sidebar containing the head widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

if (!is_active_sidebar('sidebar-2')) {
  return;
}
?>
<aside class="widget-area" aria-label="<?php esc_attr_e('Head Banner', 'zanblog-plus'); ?>">
  <?php dynamic_sidebar('sidebar-2') ?>
</aside>