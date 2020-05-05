<?php

/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

?>
<div class="site-header navbar navbar-inverse" role="banner">
    <div class="container-fluid">
        <header class="site-branding navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="top-menu">
                <i class="fa fa-bars"></i>
            </button>
            <div class="navbar-brand">
                <?php zan_the_custom_logo(); ?>
                <a class="title-home-link <?php if(has_custom_logo()) echo 'screen-reader-text'?>" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php if (is_front_page() && is_home()) : ?>
                        <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                    <?php else : ?>
                        <p class="site-title"><?php bloginfo('name'); ?></p>
                    <?php
                    endif;

                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) :
                    ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                </a>
            </div>
        </header>
        <nav id="top-menu" class="collapse navbar-collapse" role="navigation" aria-label="<?php esc_attr_e('Top Menu', 'default'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'top',
                    'container' => '',
                    'menu_class' => 'nav navbar-nav',
                    'fallback_cb' => false
                )
            );
            ?>
            <div class="if-navbar-fixed navbar-right hidden-xs">
                <i class="fa fa-thumbtack"></i>
                <input type="checkbox">
            </div>
            <?php echo str_replace('class="search-form"', 'class="search-form navbar-form navbar-right"', get_search_form(array('echo' => false))); ?>
        </nav>
    </div>
</div>