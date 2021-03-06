<?php
/**
 * The template part for displaying top navigation
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<header class="navbar-top navbar navbar-inverse navbar-fixed-top" role="banner">
    <div class="container-fluid">
        <div class="site-branding navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="top-menu">
                <i class="fas fa-bars"></i>
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
        </div>
        <div class="if-navbar-fixed navbar-right hidden-xs" data-state="checked">
            <i class="fas fa-thumbtack"></i>
        </div>
        <nav id="top-menu" class="collapse navbar-collapse" role="navigation" aria-label="<?php esc_attr_e('Top Menu', 'zanblog-plus'); ?>">
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
            <div class="navbar-form navbar-right">
                <?php get_search_form(); ?>
            </div>
        </nav>
    </div>
</header>