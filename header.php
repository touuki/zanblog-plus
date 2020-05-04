<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'default'); ?></a>

  <div class="site-header navbar navbar-inverse" role="banner">
    <div class="container-fluid">
      <header class="site-branding navbar-header">
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#top-menu" aria-expanded="false">
          <i class="fa fa-bars"></i>
        </button>
        <div class="navbar-brand">
          <?php zan_the_custom_logo(); ?>
        </div>
      </header>
      <nav id="top-menu" class="collapse navbar-collapse">
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'top',
            'container' => '',
            'menu_class' => 'nav navbar-nav',
            'walker' => new Zan_Nav_Menu,
            'fallback_cb' => false
          )
        );
        ?>
      </nav>
    </div>
    <div id="if-fixed" class="pull-right hidden-xs">
      <i class="fa fa-thumbtack"></i>
      <input type="checkbox">
    </div>
  </div>

  <div class="site-content-contain">
    <div id="content" class="container">