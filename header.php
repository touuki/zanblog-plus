<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header id="zan-header" class="navbar navbar-inverse">
    <nav class="container">
      <a href="<?php echo site_url(); ?>">
        <div class="navbar-brand"></div>
      </a>
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="fa fa-reorder fa-lg"></span>
      </button>
      <div class="navbar-collapse bs-navbar-collapse collapse">
        <?php
        $defaults = array(
          'container' => '',
          'menu_class' => 'nav navbar-nav',
          'walker' => new Zan_Nav_Menu('')
        );
        wp_nav_menu($defaults);
        ?>
      </div>
    </nav>
    <div id="if-fixed" class="pull-right visible-lg visible-md">
      <i class="fa fa-thumb-tack"></i>
      <input type="checkbox">
    </div>
  </header>

  <div id="zan-bodyer">
    <div class="container">