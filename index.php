<?php 
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 * @version 1.0
 */

get_header(); ?>
<div class="row">
	<main class="col-md-8" role="main">

		<?php if (is_home() && is_front_page()) : ?>
			<!-- Home Banner Start -->
			<header id="banner" role="banner" class="widget-area" aria-label="<?php esc_attr_e('Banner', 'default'); ?>">
				<?php dynamic_sidebar('sidebar-2') ?>
			</header>
			<!-- Home Banner End-->
		<?php else : ?>
			<!-- 面包屑 -->
			<?php zan_breadcrumb(); ?>
			<!-- 面包屑 -->
		<?php endif; ?>

		<?php
		if (have_posts()) :

			// Start the Loop.
			while (have_posts()) :
				the_post();

				/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that
					 * will be used instead.
					 */
				get_template_part('template-parts/content', get_post_format());

			endwhile;

			the_posts_pagination(array(
				'prev_text'          => '«',
				'next_text'          => '»',
			));
		else :

			get_template_part('template-parts/content', 'none');

		endif;
		?>
	</main>

	<?php get_sidebar(); ?>
</div>
<?php get_footer();
