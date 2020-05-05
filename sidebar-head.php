<?php

/**
 * The sidebar containing the head widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

if (!is_active_sidebar('sidebar-2')) {
  return;
}
?>
<header id="banner" class="widget-area" role="banner" aria-label="<?php esc_attr_e('Banner', 'default'); ?>">
  <?php dynamic_sidebar('sidebar-2') ?>
</header>