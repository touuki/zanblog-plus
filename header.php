<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "content" div.
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'zanblog-plus'); ?></a>
  <?php get_template_part('template-parts/navigation', 'top'); ?>
  <div class="body-padding-top"></div>
  <div id="content" class="site-content-contain container">